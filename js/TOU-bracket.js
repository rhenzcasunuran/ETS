let url = 'https://docs.google.com/spreadsheets/d/1aYVJ68IonLwiFKHKV1ZaT9QW4cdZ-g5XIc6N4KX1BN0/gviz/tq?';
const query = encodeURIComponent('Select A');
url = url + '&tq=' + query;

fetch(url)
.then(res => res.text())
.then(rep =>{

const data = JSON.parse(rep.substr(47).slice(0,-2));

const row01 = document.createElement('tr');
Player1.append(row01);
const row02 = document.createElement('tr');
Player2.append(row02);
const row03 = document.createElement('tr');
Player3.append(row03);
const row04 = document.createElement('tr');
Player4.append(row04);
const row05 = document.createElement('tr');
Player5.append(row05);
const row06 = document.createElement('tr');
Player6.append(row06);
const row07 = document.createElement('tr');
Player7.append(row07);
const row08 = document.createElement('tr');
Player8.append(row08);

data.table.cols.forEach((heading)=>{
const cell = document.createElement('option');
cell.textContent = heading.label;

row01.append(cell);
row02.append(cell);
row03.append(cell);
row04.append(cell);
row05.append(cell);
row06.append(cell);
row07.append(cell);
row08.append(cell);
})

data.table.rows.forEach((main)=>{
const container1 = document.createElement('option');
Player1.append(container1);

const container2 = document.createElement('option');
Player2.append(container2);

const container3 = document.createElement('option');
Player3.append(container3);

const container4 = document.createElement('option');
Player4.append(container4);

const container5 = document.createElement('option');
Player5.append(container5);

const container6 = document.createElement('option');
Player6.append(container6);

const container7 = document.createElement('option');
Player7.append(container7);

const container8 = document.createElement('option');
Player8.append(container8);


main.c.forEach((element)=> {

    const cell1 =  document.createElement('option');
    cell1.textContent = element.v;

    const cell2 =  document.createElement('option');
    cell2.textContent = element.v;

    const cell3 =  document.createElement('option');
    cell3.textContent = element.v;

    const cell4 =  document.createElement('option');
    cell4.textContent = element.v;

    const cell5 =  document.createElement('option');
    cell5.textContent = element.v;

    const cell6 =  document.createElement('option');
    cell6.textContent = element.v;

    const cell7 =  document.createElement('option');
    cell7.textContent = element.v;

    const cell8 =  document.createElement('option');
    cell8.textContent = element.v;


    container1.append(cell1);
    container2.append(cell2);
    container3.append(cell3);
    container4.append(cell4);
    container5.append(cell5);
    container6.append(cell6);
    container7.append(cell7);
    container8.append(cell8);

})
})
})

const Result00 = document.getElementById("Result0");
//------------------------Box 1-------------------------------
{
    const Res01 = document.getElementById("Result1");
    const Res02 = document.getElementById("Result2");

    const Name01 = document.getElementById("Player1");
    const Name02 = document.getElementById("Player2");

    Res01.addEventListener("change",()=>{
        let Result01 = parseInt(Res01.value);

        if(Result01 === parseInt(Result00.value)){
            document.getElementById("Player9").innerHTML = Name01.value;

        } else if (Result01 != parseInt(Result00.value)){
            document.getElementById("Player9").innerHTML = "";            
        }
    })
    Res02.addEventListener("change",()=>{
        let Result02 = parseInt(Res02.value);

        if(Result02 === parseInt(Result00.value)){
            document.getElementById("Player9").innerHTML = Name02.value;

        } else if (Result02 != parseInt(Result00.value)){
            document.getElementById("Player9").innerHTML = "";            
        }
    })

}
//------------------------Box 2-------------------------------
{
    const Res01 = document.getElementById("Result3");
    const Res02 = document.getElementById("Result4");

    const Name01 = document.getElementById("Player3");
    const Name02 = document.getElementById("Player4");

    Res01.addEventListener("change",()=>{
        let Result01 = parseInt(Res01.value);

        if(Result01 === parseInt(Result00.value)){
            document.getElementById("Player10").innerHTML = Name01.value;

        } else if (Result01 != parseInt(Result00.value)){
            document.getElementById("Player10").innerHTML = "";            
        }
    })
    Res02.addEventListener("change",()=>{
        let Result02 = parseInt(Res02.value);

        if(Result02 === parseInt(Result00.value)){
            document.getElementById("Player10").innerHTML = Name02.value;

        } else if (Result02 != parseInt(Result00.value)){
            document.getElementById("Player10").innerHTML = "";            
        }
    })

}
//------------------------Box 3-------------------------------
{
    const Res01 = document.getElementById("Result5");
    const Res02 = document.getElementById("Result6");

    const Name01 = document.getElementById("Player5");
    const Name02 = document.getElementById("Player6");

    Res01.addEventListener("change",()=>{
        let Result01 = parseInt(Res01.value);

        if(Result01 === parseInt(Result00.value)){
            document.getElementById("Player11").innerHTML = Name01.value;

        } else if (Result01 != parseInt(Result00.value)){
            document.getElementById("Player11").innerHTML = "";            
        }
    })
    Res02.addEventListener("change",()=>{
        let Result02 = parseInt(Res02.value);

        if(Result02 === parseInt(Result00.value)){
            document.getElementById("Player11").innerHTML = Name02.value;

        } else if (Result02 != parseInt(Result00.value)){
            document.getElementById("Player11").innerHTML = "";            
        }
    })

}
//------------------------Box 4-------------------------------
{
    const Res01 = document.getElementById("Result7");
    const Res02 = document.getElementById("Result8");

    const Name01 = document.getElementById("Player7");
    const Name02 = document.getElementById("Player8");

    Res01.addEventListener("change",()=>{
        let Result01 = parseInt(Res01.value);

        if(Result01 === parseInt(Result00.value)){
            document.getElementById("Player12").innerHTML = Name01.value;

        } else if (Result01 != parseInt(Result00.value)){
            document.getElementById("Player12").innerHTML = "";            
        }
    })
    Res02.addEventListener("change",()=>{
        let Result02 = parseInt(Res02.value);

        if(Result02 === parseInt(Result00.value)){
            document.getElementById("Player12").innerHTML = Name02.value;

        } else if (Result02 != parseInt(Result00.value)){
            document.getElementById("Player12").innerHTML = "";            
        }
    })

}

//------------------------Semi Finals Box 1-------------------------------

{
    const Res01 = document.getElementById("Result9");
    const Res02 = document.getElementById("Result10");

    const Name01 = document.getElementById("Player9");
    const Name02 = document.getElementById("Player10");

    Res01.addEventListener("change",()=>{
        let Result01 = parseInt(Res01.value);

        if(Result01 === parseInt(Result00.value)){
            document.getElementById("Player13").innerHTML = Name01.innerHTML;

        } else if (Result01 != parseInt(Result00.value)){
            document.getElementById("Player13").innerHTML = "";            
        }
    })
    Res02.addEventListener("change",()=>{
        let Result02 = parseInt(Res02.value);

        if(Result02 === parseInt(Result00.value)){
            document.getElementById("Player13").innerHTML = Name02.innerHTML;

        } else if (Result02 != parseInt(Result00.value)){
            document.getElementById("Player13").innerHTML = "";            
        }
    })

}
//------------------------Semi Finals Box 2-------------------------------
{
    const Res01 = document.getElementById("Result11");
    const Res02 = document.getElementById("Result12");

    const Name01 = document.getElementById("Player11");
    const Name02 = document.getElementById("Player12");

    Res01.addEventListener("change",()=>{
        let Result01 = parseInt(Res01.value);

        if(Result01 === parseInt(Result00.value)){
            document.getElementById("Player14").innerHTML = Name01.innerHTML;

        } else if (Result01 != parseInt(Result00.value)){
            document.getElementById("Player14").innerHTML = "";            
        }
    })
    Res02.addEventListener("change",()=>{
        let Result02 = parseInt(Res02.value);

        if(Result02 === parseInt(Result00.value)){
            document.getElementById("Player14").innerHTML = Name02.innerHTML;

        } else if (Result02 != parseInt(Result00.value)){
            document.getElementById("Player14").innerHTML = "";            
        }
    })

}