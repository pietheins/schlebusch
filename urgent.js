var bericht = "<h2>dit moet je echt zien</h2>";
       // dit bericht wordt getoond TOT DE STOPDATUM IS BEREIKT    

var stopdatum = new Date("2023-07-12");   
  // Er staat hier al een 'oude' datum ingevuld
  // Verander ALLEEN DEZE DATUM !!!
  // Normaal gesproken vul je de datum van MORGEN in!  
  // in de vorm "JJJJ-MM-DD"  (vergeet de voorloopnullen niet)
  
  
var ditmoment = new Date();
  // Hier is niks ingevuld.  LAAT DAT ZO !!!
  // ditmoment is dus NU  

if(stopdatum.getTime() > ditmoment.getTime())
   // dus als ditmoment nog eerder is dan de stopdatum,    
{
   // dan wordt dit stukje tekst getoond: 
  document.write(bericht) ;
}
