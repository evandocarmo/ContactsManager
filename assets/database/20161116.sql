# Log 
# ENUM specific definition for each error type.

        ALTER TABLE `log` 
              CHANGE `log_type` `log_type` 
              ENUM('foreigner','user','visits','status','category','personal_users') 
CHARACTER SET latin1 
      COLLATE latin1_swedish_ci NOT NULL;