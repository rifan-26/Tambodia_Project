-- Add missing columns to schedules table
ALTER TABLE `schedules` 
ADD COLUMN `layout_type` VARCHAR(255) DEFAULT 'grid' AFTER `time`,
ADD COLUMN `layout_positions` JSON NULL AFTER `layout_type`,
ADD COLUMN `display_duration` INT DEFAULT 10 AFTER `layout_positions`,
ADD COLUMN `auto_rotate` BOOLEAN DEFAULT TRUE AFTER `display_duration`,
ADD COLUMN `layout_settings` JSON NULL AFTER `auto_rotate`,
ADD COLUMN `is_active` BOOLEAN DEFAULT TRUE AFTER `layout_settings`;