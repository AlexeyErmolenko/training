CREATE TABLE "roles" (
    id SMALLSERIAL NOT NULL,
    name varchar(40),
    slug varchar(40),
    PRIMARY KEY (id));
CREATE TABLE "Users" (
    "id" BIGSERIAL NOT NULL,
    "firstName" varchar(40) NOT NULL,
    "lastName" varchar(40),
    "email" varchar(100) NOT NULL,
    "password" varchar(100),
    "avatarUrl" varchar(255),
    "role_id" SMALLINT NOT NULL,
    "createdAt" timestamp DEFAULT now() NOT NULL,
    "updatedAt" timestamp,
    "deletedAt" timestamp,
    PRIMARY KEY ("id"));
CREATE TABLE "CarMakes" (
    "id" BIGSERIAL NOT NULL,
    "name" varchar(255),
    "createdAt" timestamp DEFAULT now() NOT NULL,
    "updatedAt" timestamp,
    "deletedAt" timestamp,
    PRIMARY KEY ("id"));
CREATE TABLE "CarModels" (
    "id" BIGSERIAL NOT NULL,
    "makeId" BIGINT NOT NULL,
    "name" varchar(255),
    "yearStart" SMALLINT,
    "yearEnd" SMALLINT,
    "createdAt" timestamp DEFAULT now() NOT NULL,
    "updatedAt" timestamp,
    "deletedAt" timestamp,
    PRIMARY KEY ("id"));
CREATE TABLE "CarTrims" (
    "id" BIGSERIAL NOT NULL,
    "modelId" BIGINT NOT NULL,
    "name" varchar(255),
    "createdAt" timestamp DEFAULT now() NOT NULL,
    "updatedAt" timestamp,
    "deletedAt" timestamp,
    PRIMARY KEY ("id"));
CREATE TABLE "Listings" (
    "id" BIGSERIAL NOT NULL,
    "carModelId" BIGINT NOT NULL,
    "carTrimId" BIGINT NOT NULL,
    "createdBy" BIGINT NOT NULL,
    "year" SMALLINT,
    "price" NUMERIC DEFAULT 0 NOT NULL,
    "createdAt" timestamp DEFAULT now() NOT NULL,
    "updatedAt" timestamp,
    "deletedAt" timestamp,
    PRIMARY KEY ("id"));
CREATE TABLE "Comments" (
    "id" BIGSERIAL NOT NULL,
    "listingId" BIGINT NOT NULL,
    "createdBy" BIGINT NOT NULL,
    "message" varchar(500),
    "createdAt" timestamp DEFAULT now() NOT NULL,
    "updatedAt" timestamp,
    "deletedAt" timestamp,
    PRIMARY KEY ("id"));
CREATE TABLE "Images" (
    "id" BIGSERIAL NOT NULL,
    "listingId" BIGINT NOT NULL,
    "path" varchar(255) NOT NULL,
    "thumbnailPath" varchar(255) NOT NULL,
    "sequence" INTEGER NOT NULL,
    "createdAt" timestamp DEFAULT now() NOT NULL,
    "updatedAt" timestamp,
    "deletedAt" timestamp,
    PRIMARY KEY ("id"));
ALTER TABLE "Users" ADD CONSTRAINT FKUsers162913 FOREIGN KEY ("role_id") REFERENCES "roles" ("id");
ALTER TABLE "CarModels" ADD CONSTRAINT FK_carModels_carMakes FOREIGN KEY ("makeId") REFERENCES "CarMakes" ("id")
    ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE "CarTrims" ADD CONSTRAINT  FK_carTrims_carModels FOREIGN KEY ("modelId") REFERENCES "CarModels" ("id")
    ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE "Listings" ADD CONSTRAINT  FK_listings_carModels FOREIGN KEY ("carModelId") REFERENCES "CarModels" ("id")
    ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE "Listings" ADD CONSTRAINT  FK_listings_carTrims FOREIGN KEY ("carTrimId") REFERENCES "CarTrims" ("id")
    ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE "Listings" ADD CONSTRAINT  FK_listings_users FOREIGN KEY ("createdBy") REFERENCES "Users" ("id")
    ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE "Comments" ADD CONSTRAINT  FK_comments_users FOREIGN KEY ("createdBy") REFERENCES "Users" ("id")
    ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE "Comments" ADD CONSTRAINT  FK_comments_listings FOREIGN KEY ("listingId") REFERENCES "Listings" ("id")
    ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE "Images" ADD CONSTRAINT  FK_images_listings FOREIGN KEY ("listingId") REFERENCES "Listings" ("id")
    ON UPDATE CASCADE ON DELETE CASCADE;
