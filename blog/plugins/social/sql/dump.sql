ALTER TABLE  `user` ADD  `user_profile_skype` VARCHAR( 300 ) NULL AFTER  `user_profile_icq` ;
ALTER TABLE  `user` ADD  `user_profile_jabber` VARCHAR( 300 ) NULL AFTER  `user_profile_skype` ;
ALTER TABLE  `user` ADD  `user_profile_vk` VARCHAR( 300 ) NULL AFTER  `user_profile_jabber` ;
ALTER TABLE  `user` ADD  `user_profile_lj` VARCHAR( 300 ) NULL AFTER  `user_profile_vk` ;