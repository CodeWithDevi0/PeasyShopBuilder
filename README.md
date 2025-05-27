#new-added-May-27

Query for inserting our admin account
-- Insert admin account
INSERT INTO users (
    f_name,
    l_name,
    username,
    email,
    password,
    is_admin,
    created_at
) VALUES (
    'Admin',
    'User',
    'admin',
    'admin@peasy.com',
    'admin123',  -- Remember to use proper password hashing in production
    1,          -- 1 indicates admin status
    NOW()
);