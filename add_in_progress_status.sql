-- contactsテーブルのstatusカラムにin_progressを追加するSQL
ALTER TABLE contacts MODIFY COLUMN status ENUM('pending', 'in_progress', 'replied', 'closed') DEFAULT 'pending';
