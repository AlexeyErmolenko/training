<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Swagger UI</title>
    <link rel="stylesheet" type="text/css" href="/swagger-ui/swagger-ui.css" >
    <link rel="icon" type="image/png" href="/swagger-ui/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/swagger-ui/favicon-16x16.png" sizes="16x16" />
    <style>
        html
        {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after
        {
            box-sizing: inherit;
        }

        body
        {
            margin:0;
            background: #fafafa;
        }
    </style>
</head>

<body>
<div id="swagger-ui"></div>

<script src="/swagger-ui/swagger-ui-bundle.js"> </script>
<script src="/swagger-ui/swagger-ui-standalone-preset.js"> </script>
<script>
  window.onload = function() {

    // Build a system
    window.ui  = SwaggerUIBundle({
      url: "/swagger-ui/api.yaml?checksum={{ $checksum }}",
      dom_id: '#swagger-ui',
      deepLinking: true,
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
      ],
      plugins: [
        SwaggerUIBundle.plugins.DownloadUrl
      ],
      layout: "StandaloneLayout"
    });
  }
</script>
</body>
</html>
