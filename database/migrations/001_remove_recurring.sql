-- Migration: Remove unused recurring column from events table
-- Run this if you already have a database with the recurring field

ALTER TABLE events DROP COLUMN IF EXISTS recurring;
