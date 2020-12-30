PRAGMA foreign_keys = false;
PRAGMA ignore_check_constraints = true;

-- ----------------------------
--  Table structure for "groups"
-- ----------------------------
DROP TABLE IF EXISTS "groups";
CREATE TABLE "groups" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "name" text NOT NULL UNIQUE,
  "permissions" text,
  "created_at" integer NOT NULL DEFAULT 0,
  "updated_at" integer NOT NULL DEFAULT 0
);

CREATE UNIQUE INDEX IF NOT EXISTS "groups_name_unique" ON "groups" ( "name" );
 
INSERT INTO "groups" VALUES (1, "Administrators", "{""|^/admin(/.*)?$|"":1, ""|^/api(/.*)?$|"":1}", date('now'), date('now'));
INSERT INTO "groups" VALUES (2, "Users", "{""|^/api(/.*)?$|"":1}", date('now'), date('now'));

-- ----------------------------
--  Table structure for "users"
-- ----------------------------
DROP TABLE IF EXISTS "users";

CREATE TABLE "users" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "email" text NOT NULL UNIQUE,
  "password" text NOT NULL,
  "permissions" text,
  "activated" integer NOT NULL DEFAULT 0,
  "activation_code" text,
  "activated_at" text,
  "last_login" text,
  "persist_code" text,
  "reset_password_code" text,
  "first_name" text,
  "last_name" text,
  "created_at" integer NOT NULL DEFAULT 0,
  "updated_at" integer NOT NULL DEFAULT 0
);

CREATE UNIQUE INDEX IF NOT EXISTS "users_email_unique" ON "users" ( "email" );
CREATE INDEX IF NOT EXISTS "users_activation_code_index" ON "users" ( "activation_code" );
CREATE INDEX IF NOT EXISTS "users_reset_password_code_index" ON "users" ( "reset_password_code" );

-- ----------------------------
--  Table structure for "throttle"
-- ----------------------------
DROP TABLE IF EXISTS "throttle";

CREATE TABLE "throttle" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "user_id" integer NOT NULL,
  "ip_address" text NULL,
  "attempts" integer NOT NULL DEFAULT '0',
  "suspended" integer NOT NULL DEFAULT '0',
  "banned" integer NOT NULL DEFAULT '0',
  "last_attempt_at" integer NULL DEFAULT NULL,
  "suspended_at" integer NULL DEFAULT NULL,
  "banned_at" integer NULL DEFAULT NULL
);

CREATE INDEX IF NOT EXISTS "fk_user_id" ON "throttle" ( "user_id" );

-- ----------------------------
--  Table structure for "users_groups"
-- ----------------------------
DROP TABLE IF EXISTS "users_groups";

CREATE TABLE "users_groups" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "user_id" integer NOT NULL,
  "group_id" integer NOT NULL
);

-- ----------------------------
--  Table structure for "category"
-- ----------------------------
DROP TABLE IF EXISTS "categories";
CREATE TABLE IF NOT EXISTS "categories" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "parent_id" integer REFERENCES "categories" ("id") ON DELETE SET NULL,
  "description" text NOT NULL UNIQUE,
  "created_at" integer NOT NULL DEFAULT 0,
  "updated_at" integer NOT NULL DEFAULT 0
);

DROP TABLE IF EXISTS "assignment_rules";
CREATE TABLE IF NOT EXISTS "assignment_rules" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "category_id" integer REFERENCES "categories" ("id") ON DELETE CASCADE,
  "field" text NOT NULL,
  "pattern" text NOT NULL,
  "created_at" integer NOT NULL DEFAULT 0,
  "updated_at" integer NOT NULL DEFAULT 0
);

-- ----------------------------
--  Table structure for "account"
-- ----------------------------
DROP TABLE IF EXISTS "accounts";
CREATE TABLE IF NOT EXISTS "accounts" (
  "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
  "iban" text NOT NULL UNIQUE,
  "description" text,
  "holder" text,
  "created_at" integer NOT NULL DEFAULT 0,
  "updated_at" integer NOT NULL DEFAULT 0
);

-- ----------------------------
--  Table structure for "notebook"
-- ----------------------------
DROP TABLE IF EXISTS "transactions";
CREATE TABLE IF NOT EXISTS "transactions" (
   "id" integer NOT NULL PRIMARY KEY AUTOINCREMENT,
   "category_id" integer REFERENCES "categories" ("id") ON DELETE SET NULL,
   "account_id" integer NOT NULL REFERENCES "accounts" ("id") ON DELETE CASCADE,
   "counter_account_iban" text,
   "counter_account_name" text,
   "sequence_id" integer NOT NULL,
   "date" integer NOT NULL DEFAULT 0,
   "interest_date" integer NOT NULL DEFAULT 0,
   "sign" text NOT NULL,
   "amount" integer NOT NULL DEFAULT 0,
   "balance_after_transaction" integer NOT NULL DEFAULT 0,
   "currency" text NOT NULL,
   -- "contra_account" text NOT NULL,
   -- "counterparty_name" text NOT NULL,
   "reference" text,
   "description" text,
   "additional_description" text,
   "created_at" integer NOT NULL DEFAULT 0,
   "updated_at" integer NOT NULL DEFAULT 0
);

-- CREATE INDEX IF NOT EXISTS "user" ON "notebook" ( "user_id" );
CREATE UNIQUE INDEX IF NOT EXISTS "unique_account_sequence" ON "transactions" ( "account_id", "sequence_id" );

PRAGMA foreign_keys = true;
PRAGMA ignore_check_constraints = false;
PRAGMA foreign_keys = ON;
