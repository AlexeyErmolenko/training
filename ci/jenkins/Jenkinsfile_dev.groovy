import groovy.json.JsonSlurperClassic as Json
saritasa = fileLoader.fromGit('utils/saritasa.groovy', 'ssh://gitblit.saritasa.com/saritasa/jenkins-pipeline.git', '0.0.12', 'jenkins-ssh-credential', '')

config = [
  project: 'training_start',
  environment: 'development',
  image: 'registry.saritasa.com/training_start/backend:develop',
  vault_url: 'https://vault.saritasa.io:8200/v1/secret/training_start-backend-develop'
]

node {
  stage('scm') {
    checkout(scm)
  }

  stage('credentials') {
    vaultResponse = httpRequest(customHeaders: [[maskValue: true, name: 'X-Vault-Token', value: "${env.VAULT_TOKEN}"]], url: config.vault_url)
    secrets = new Json().parseText(vaultResponse.content).data
    configContent = readFile('.env.template')
    for (secret in secrets) {
      configContent = configContent.replace("%${secret.key}%", "${secret.value}")
    }
    writeFile(file: '.env', text: configContent)
  }

  stage('swagger') {
    saritasa.swagger_generate('index.yaml', 'docs/API', 'api.yaml')
    def mobile_version = saritasa.swagger_version_get('api.yaml')
    sh([script: "s3cmd put api.yaml s3://saritasa-swagger/${config.project}/${env.GIT_BRANCH}/${config.project}-latest.yaml"])
    sh([script: "s3cmd put api.yaml s3://saritasa-swagger/${config.project}/${env.GIT_BRANCH}/${config.project}-${mobile_version}.yaml"])
  }

  stage('docker') {
    sh("docker build -f ci/docker/Dockerfile.base --build-arg PHP_ENV=${config.environment} --tag training_start:base .")
    sh("docker build -f ci/docker/Dockerfile --build-arg PHP_ENV=${config.environment} --tag ${config.image} .")
  }

  stage('tests') {
    if ("${RUN_TESTS}" == 'true') {
      wrap([$class: 'AnsiColorBuildWrapper', 'colorMapName': 'XTerm']) {
        sh"docker-compose -f ci/docker/testing_develop.yml -p training_start_tests run --rm tests"
        sh"docker-compose -f ci/docker/testing_develop.yml -p training_start_tests down"
      }
    }
  }

  stage('migrations') {
    if ("${RUN_MIGRATION}" == 'true') {
      credentials = new Json().parseText(
        httpRequest(
          customHeaders: [[maskValue: true, name: 'X-Vault-Token', value: "${env.VAULT_TOKEN}"]],
          url: config.vault_url
        ).content
      ).data

    sh("""docker run --name ${config.project}-${config.development}-migrations --entrypoint php \
      -e DB_HOST='${credentials.DB_HOST}' \
      -e DB_DATABASE='${credentials.DB_DATABASE}' \
      -e DB_USERNAME='${credentials.DB_USERNAME}' \
      -e DB_PASSWORD='${credentials.DB_PASSWORD}' \
      --rm ${config.image} \
      -c '/usr/bin/php artisan migrate --force --no-interaction'""")
    }
  }

  stage('registry') {
    withCredentials([usernamePassword(credentialsId: 'jenkins-gitlab-token', passwordVariable: 'PASSWORD', usernameVariable: 'USERNAME')]) {
      sh("docker login --username ${env.USERNAME} --password ${env.PASSWORD} registry.saritasa.com")
      sh("docker push ${config.image}")
    }
  }

  stage('rancher') {
    sh("rancher-compose -p ${config.project} -f ci/docker/develop.yaml up backend -d --force-recreate --confirm-upgrade")
  }

  stage('clean') {
    sh("docker rm ${config.image} --force || true")
  }

  stage('sonarqube') {
    SONAR = tool name: 'sonarqube-latest'
    NODEJS = tool name: 'nodejs-latest', type: 'nodejs'
    withEnv(["PATH=$PATH:${SONAR}/bin:${NODEJS}/bin"]) {
      withSonarQubeEnv('sonarqube.saritasa.com') {
        sh('sonar-scanner')
      }
    }
  }
}
