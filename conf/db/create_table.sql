DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS users CASCADE;

CREATE TABLE users(
    id SERIAL PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    delete_flag INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT current_timestamp,
    updated_at TIMESTAMP DEFAULT current_timestamp
);

CREATE TABLE comments(
    comment_id SERIAL PRIMARY KEY,
    parent_comment_id INTEGER REFERENCES comments(comment_id),
    user_id INTEGER NOT NULL REFERENCES users(id),
    comment VARCHAR(511) NOT NULL,
    image_path VARCHAR(255),
    delete_flag INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT current_timestamp,
    updated_at TIMESTAMP DEFAULT current_timestamp
);
