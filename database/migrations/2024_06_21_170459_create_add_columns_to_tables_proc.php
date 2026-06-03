<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `add_columns_to_tables`()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE tableName VARCHAR(255);
    DECLARE cur CURSOR FOR SELECT table_name FROM information_schema.tables WHERE table_schema = 'citrus' AND table_type = 'BASE TABLE';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    read_tables_loop: LOOP
        FETCH cur INTO tableName;
        IF done THEN
            LEAVE read_tables_loop;
        END IF;

        -- Add or modify created_by column
        SET @sql := CONCAT('
            IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_name = \"', tableName, '\" AND column_name = \"created_by\") THEN
                ALTER TABLE ', tableName, ' ADD COLUMN created_by INT(10) UNSIGNED NULL;
            ELSE
                ALTER TABLE ', tableName, ' MODIFY COLUMN created_by INT(10) UNSIGNED NULL;
            END IF;'
        );
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

        -- Add or modify deleted_by column
        SET @sql := CONCAT('
            IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_name = \"', tableName, '\" AND column_name = \"deleted_by\") THEN
                ALTER TABLE ', tableName, ' ADD COLUMN deleted_by INT(10) UNSIGNED NULL;
            ELSE
                ALTER TABLE ', tableName, ' MODIFY COLUMN deleted_by INT(10) UNSIGNED NULL;
            END IF;'
        );
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

        -- Add or modify updated_by column
        SET @sql := CONCAT('
            IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_name = \"', tableName, '\" AND column_name = \"updated_by\") THEN
                ALTER TABLE ', tableName, ' ADD COLUMN updated_by INT(10) UNSIGNED NULL;
            ELSE
                ALTER TABLE ', tableName, ' MODIFY COLUMN updated_by INT(10) UNSIGNED NULL;
            END IF;'
        );
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

        -- Add or modify created_at column
        SET @sql := CONCAT('
            IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_name = \"', tableName, '\" AND column_name = \"created_at\") THEN
                ALTER TABLE ', tableName, ' ADD COLUMN created_at TIMESTAMP NULL DEFAULT NULL;
            ELSE
                ALTER TABLE ', tableName, ' MODIFY COLUMN created_at TIMESTAMP NULL DEFAULT NULL;
            END IF;'
        );
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

        -- Add or modify updated_at column
        SET @sql := CONCAT('
            IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_name = \"', tableName, '\" AND column_name = \"updated_at\") THEN
                ALTER TABLE ', tableName, ' ADD COLUMN updated_at TIMESTAMP NULL DEFAULT NULL;
            ELSE
                ALTER TABLE ', tableName, ' MODIFY COLUMN updated_at TIMESTAMP NULL DEFAULT NULL;
            END IF;'
        );
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

        -- Add or modify deleted_at column
        SET @sql := CONCAT('
            IF NOT EXISTS (SELECT * FROM information_schema.columns WHERE table_name = \"', tableName, '\" AND column_name = \"deleted_at\") THEN
                ALTER TABLE ', tableName, ' ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;
            ELSE
                ALTER TABLE ', tableName, ' MODIFY COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL;
            END IF;'
        );
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

    END LOOP read_tables_loop;

    CLOSE cur;
END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS add_columns_to_tables");
    }
};
