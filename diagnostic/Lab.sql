select * from testmastersetn
select * from testMasterSet

select * from biochem where regno = '234682'


SELECT id, rno, opid, billdate, billno, pname, addedBy, servname, servrate
FROM billing 
INNER JOIN servmaster ON billing.servname = servmaster.servname
ORDER BY id DESC