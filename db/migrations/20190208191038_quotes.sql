-- migrate:up
CREATE TABLE quotes(
    id int PRIMARY KEY AUTO_INCREMENT,
    content varchar(1000) UNIQUE,
	created_at timestamp DEFAULT current_timestamp,
	updated_at timestamp
);

-- migrate:down
DROP TABLE quotes;
