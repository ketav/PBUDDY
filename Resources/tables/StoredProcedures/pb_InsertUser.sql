CREATE DEFINER=`root`@`localhost` PROCEDURE `pb_InsertUser`(IN `name` VARCHAR(500), IN `emailId` VARCHAR(1000), IN `sex` VARCHAR(10), IN `geography` VARCHAR(1000), IN `userId` INT(11))
BEGIN
DECLARE userExist INT;
SELECT COUNT(1) INTO userExist FROM user_detail where user_id=userId;
IF userExist = 0
THEN
BEGIN
INSERT INTO `user_detail`(`name`, `email_id`, `sex`, `geography`, `user_id`)
VALUES (name,emailId,sex,geography,userId);
END;
END IF;

END