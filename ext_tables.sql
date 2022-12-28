#
# Table structure for table 'tx_civiladmin_dienstleistung_contacts_mm'
# 
#
CREATE TABLE tx_civiladmin_dienstleistung_contacts_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_civiladmin_dienstleistung'
#
CREATE TABLE tx_civiladmin_dienstleistung (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    title tinytext,
   	slug varchar(255) DEFAULT '' NOT NULL,
    synonyms tinytext,
    keywords tinytext,
    description text,
    documents text,
    costs text,
    laws text,
    forms text,
    unit text,
    contacts int(11) DEFAULT '0' NOT NULL,
    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    synonym_service tinytext,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);




#
# Table structure for table 'tx_civiladmin_contact_contacts_mm'
# 
#
CREATE TABLE tx_civiladmin_contact_contacts_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);




#
# Table structure for table 'tx_civiladmin_contact_parent_mm'
# 
#
CREATE TABLE tx_civiladmin_contact_parent_mm (
  uid_local int(11) DEFAULT '0' NOT NULL,
  uid_foreign int(11) DEFAULT '0' NOT NULL,
  tablenames varchar(30) DEFAULT '' NOT NULL,
  sorting int(11) DEFAULT '0' NOT NULL,
  KEY uid_local (uid_local),
  KEY uid_foreign (uid_foreign)
);



#
# Table structure for table 'tx_civiladmin_contact'
#
CREATE TABLE tx_civiladmin_contact (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    sorting int(10) DEFAULT '0' NOT NULL,
    name tinytext,
   	slug varchar(255) DEFAULT '' NOT NULL,
    synonyms tinytext,
    address text,
    phone tinytext,
    fax tinytext,
    email tinytext,
    boss tinytext,
    contacts int(11) DEFAULT '0' NOT NULL,
    oeffnungszeiten text,
    parent int(11) DEFAULT '0' NOT NULL,
    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);



#
# Table structure for table 'tx_civiladmin_contacts'
#
CREATE TABLE tx_civiladmin_contacts (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    name tinytext,
    prenom tinytext,
    phone tinytext,
    fax tinytext,
    email tinytext,
    shorttext tinytext,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);



#
# Table structure for table 'tx_civiladmin_addresses'
#
CREATE TABLE tx_civiladmin_addresses (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,
    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    name tinytext,
    street tinytext,
    housenr tinytext,
    room tinytext,
    zip tinytext,
    city tinytext,
    busstation tinytext,
    
    PRIMARY KEY (uid),
    KEY parent (pid)
);