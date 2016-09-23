ALTER TABLE `cv` CHANGE `education` `education` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `cv` CHANGE `sphere` `sphere` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

ALTER TABLE `ad` CHANGE `sphere` `sphere` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


