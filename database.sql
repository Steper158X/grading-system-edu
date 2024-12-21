CREATE TABLE `students`.`students` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `no` VARCHAR(10) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `score` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;