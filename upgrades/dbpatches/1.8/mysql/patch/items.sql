alter table items add data_type  integer     DEFAULT '0' NOT NULL;
alter table items add authtype   integer     DEFAULT '0' NOT NULL;
alter table items add username   varchar(64) DEFAULT ''  NOT NULL;
alter table items add password   varchar(64) DEFAULT ''  NOT NULL;
alter table items add publickey  varchar(64) DEFAULT ''  NOT NULL;
alter table items add privatekey varchar(64) DEFAULT ''  NOT NULL;
