-- Si da error con un constraint ejecutar este comando
--ALTER TABLE people DROP CONSTRAINT DF__people__descr__19AACF41;


ALTER TABLE people ADD branch_company_id INT NULL;
ALTER TABLE people ADD company VARCHAR (255) NULL;