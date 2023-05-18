let url = 'https://docs.google.com/spreadsheets/d/169ol4qjJUyd-u6KWc8rPMK2aYPA5Qb2Kf6uNHmTOLdE/gviz/tq?';
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


data.table.cols.forEach((heading)=>{
const cell = document.createElement('option');
cell.textContent = heading.label;

row01.append(cell);
row02.append(cell);
row03.append(cell);
row04.append(cell);
row05.append(cell);
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