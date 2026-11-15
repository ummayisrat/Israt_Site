-- Full database dump (SQLite): all tables + sample data
-- Import:  sqlite3 database/database.sqlite < database.sql

BEGIN TRANSACTION;
CREATE TABLE "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"));
CREATE TABLE "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"));
CREATE TABLE "comments" ("id" integer primary key autoincrement not null, "name" varchar not null, "comment" text not null, "created_at" datetime, "updated_at" datetime);
CREATE TABLE "contact_messages" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "message" text not null, "read_at" datetime, "created_at" datetime, "updated_at" datetime);
CREATE TABLE "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" varchar not null, "queue" varchar not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP);
CREATE TABLE "gallery_items" ("id" integer primary key autoincrement not null, "title" varchar not null, "category" varchar not null, "image_url" varchar not null, "image_alt" varchar, "created_at" datetime, "updated_at" datetime);
INSERT INTO "gallery_items" VALUES(1,'Autumn','Nature','https://www.mickeyshannon.com/wp-content/uploads/2020/02/firebolt-tree-of-life.jpg','Autumn Japanese maple tree','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "gallery_items" VALUES(2,'A Quiet Gallery','Space','https://assets-global.website-files.com/6411dbc62b0a4f380f7eb33a/64ef39bc605e8460b2659e78_2308_Noorddammerlaan_HOP_michaelcerrone_6.webp','Bright gallery interior with framed artwork','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "gallery_items" VALUES(3,'Framed Memories','Art','https://www.clave.com.ec/wp-content/uploads/2021/02/MG_0948.jpg','Photography gallery exhibition','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "gallery_items" VALUES(4,'Creative Space','Interior','https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1400&q=85','Creative interior workspace','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "gallery_items" VALUES(5,'Somewhere Far','Landscape','https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1400&q=85','Mountain landscape','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "gallery_items" VALUES(6,'Beyond','Journey','https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=1400&q=85','Atmospheric natural landscape','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "gallery_items" VALUES(7,'Into the Woods','Nature','https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=1400&q=85','Forest photography','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "gallery_items" VALUES(8,'The Road','Travel','https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=1400&q=85','Open road landscape','2026-11-05 07:27:33','2026-11-05 07:27:33');
CREATE TABLE "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"));
CREATE TABLE "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null);
CREATE TABLE "journal_entries" ("id" integer primary key autoincrement not null, "title" varchar not null, "category" varchar not null default 'Journal Entry', "body" text not null, "image_url" varchar, "entry_date" date not null, "created_at" datetime, "updated_at" datetime);
INSERT INTO "journal_entries" VALUES(1,'A quiet morning','Journal Entry','There is something beautiful about an empty page waiting to be filled.

A cup of coffee, a notebook, and a few minutes of silence can sometimes be enough.','https://images.unsplash.com/photo-1634746027343-985ad425b8b5?fm=jpg&q=80&w=1600','2026-10-01 00:00:00','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "journal_entries" VALUES(2,'Things I never say','Reflection','Some thoughts are easier to write than to speak.

Perhaps that is why journals become such honest companions.','https://images.unsplash.com/photo-1456324504439-367cee3b3c32?auto=format&fit=crop&w=1600&q=85','2026-10-10 00:00:00','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "journal_entries" VALUES(3,'Starting again','Creative Notes','Starting over does not mean starting from nothing.

We carry every lesson, every mistake, and every little victory with us.','https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1600&q=85','2026-10-20 00:00:00','2026-11-05 07:27:33','2026-11-05 07:27:33');
CREATE TABLE "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);
INSERT INTO "migrations" VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO "migrations" VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO "migrations" VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO "migrations" VALUES(4,'2026_11_04_000000_create_journal_entries_table',1);
INSERT INTO "migrations" VALUES(5,'2026_11_05_000000_create_contact_messages_table',1);
INSERT INTO "migrations" VALUES(6,'2026_11_05_000001_create_comments_table',1);
INSERT INTO "migrations" VALUES(7,'2026_11_05_000002_create_stories_table',1);
INSERT INTO "migrations" VALUES(8,'2026_11_05_000003_create_gallery_items_table',1);
CREATE TABLE "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"));
CREATE TABLE "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"));
CREATE TABLE "stories" ("id" integer primary key autoincrement not null, "title" varchar not null, "body" text not null, "image_url" varchar not null, "image_alt" varchar, "created_at" datetime, "updated_at" datetime);
INSERT INTO "stories" VALUES(1,'The City','The streets were loud, but somehow she found a quiet place inside them.','https://images.squarespace-cdn.com/content/v1/5f54cd1a740fbb7a4f4f3ecb/180eb2bb-1b2d-4a21-89b4-89c913a666b0/ULVD93ufJgAWbSSuXYFN--0--y27zy_2x-clty-upscale-qgx4r.jpg','Cinematic urban street portrait','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "stories" VALUES(2,'After Rain','The rain had stopped, but the city still carried its reflection.','https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1600&q=85','Cinematic portrait photography','2026-11-05 07:27:33','2026-11-05 07:27:33');
INSERT INTO "stories" VALUES(3,'Somewhere Quiet','Perhaps we don''t always need to know where we are going.','https://images.unsplash.com/photo-1500534623283-312aade485b7?auto=format&fit=crop&w=1600&q=85','Atmospheric landscape photography','2026-11-05 07:27:33','2026-11-05 07:27:33');
CREATE TABLE "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "email_verified_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime);
INSERT INTO "users" VALUES(1,'Test User','test@example.com','2026-11-05 07:27:33','$2y$12$AsGHNsL5KTf6/y2PpLptPessVnx4OZwCpQnklXHFatBnXk0MB1y92','fRHYu8yjLv','2026-11-05 07:27:33','2026-11-05 07:27:33');
CREATE UNIQUE INDEX "users_email_unique" on "users" ("email");
CREATE INDEX "sessions_user_id_index" on "sessions" ("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions" ("last_activity");
CREATE INDEX "cache_expiration_index" on "cache" ("expiration");
CREATE INDEX "cache_locks_expiration_index" on "cache_locks" ("expiration");
CREATE INDEX "jobs_queue_index" on "jobs" ("queue");
CREATE INDEX "failed_jobs_connection_queue_failed_at_index" on "failed_jobs" ("connection", "queue", "failed_at");
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs" ("uuid");
COMMIT;
