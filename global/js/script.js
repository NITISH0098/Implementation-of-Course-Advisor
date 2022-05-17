function integer_to_roman(num) {
  if (typeof num !== 'number')
    return false;

  var digits = String(+num).split(""),
    key = ["", "C", "CC", "CCC", "CD", "D", "DC", "DCC", "DCCC", "CM",
      "", "X", "XX", "XXX", "XL", "L", "LX", "LXX", "LXXX", "XC",
      "", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX"],
    roman_num = "",
    i = 3;
  while (i--)
    roman_num = (key[+digits.pop() + (i * 10)] || "") + roman_num;
  return Array(+digits.join("") + 1).join("M") + roman_num;
}

function getNextTerm(CurrentTerm)
{
    nextTerm=[];
    ntt='';
    nty='';

    if(CurrentTerm['TYPE']=='SPRING SEMESTER')
    {
        ntt='AUTUMN SEMESTER'; nty= CurrentTerm['YEAR'];
    }
    else if(CurrentTerm['TYPE']=='AUTUMN SEMESTER'){
        ntt='SPRING SEMESTER'; nty= CurrentTerm['YEAR']+1;
    }
    return array("TYPE"=ntt,"YEAR"=nty);
}

function getPrevTerm(CurrentTerm)
{
    nextTerm=[];
    ntt='';
    nty='';

    if(CurrentTerm['TYPE']=='SPRING SEMESTER')
    {
        ntt='AUTUMN SEMESTER'; nty= CurrentTerm['YEAR']-1;
    }
    else if(CurrentTerm['TYPE']=='AUTUMN SEMESTER'){
        ntt='SPRING SEMESTER'; nty= CurrentTerm['YEAR'];
    }
    return array("TYPE"=ntt,"YEAR"=nty);
}