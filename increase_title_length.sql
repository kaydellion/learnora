-- Script to increase the title column length in ln_training table
-- First, let's check the current structure
DESCRIBE ln_training;

-- Show current title column info specifically
SHOW COLUMNS FROM ln_training WHERE Field LIKE '%title%';

-- Check current max length usage
SELECT 
    MAX(LENGTH(title)) as max_length_used,
    AVG(LENGTH(title)) as avg_length_used,
    COUNT(*) as total_records
FROM ln_training 
WHERE title IS NOT NULL;

-- Modify the title column to increase length from current to VARCHAR(500)
-- This will allow much longer titles
ALTER TABLE ln_training MODIFY COLUMN title VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Verify the change
DESCRIBE ln_training;

-- Show the updated title column info
SHOW COLUMNS FROM ln_training WHERE Field LIKE '%title%';

echo "Title column has been successfully increased to VARCHAR(500)";
