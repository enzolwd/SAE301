--liquibase formatted sql

--changeset usersae301:001
CREATE TABLE IF NOT EXISTS demo_table (
    id SERIAL PRIMARY KEY,
    label TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW()
);
