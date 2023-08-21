const draggableDivs = document.querySelectorAll('.draggableDiv');
let dragSrcEl = null;

function handleDragStart(e) {
  dragSrcEl = this;
  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault();
  }
  e.dataTransfer.dropEffect = 'move';
  return false;
}

function handleDrop(e) {
  if (e.stopPropagation) {
    e.stopPropagation();
  }

  if (dragSrcEl !== this) {
    const temp = this.innerHTML;
    this.innerHTML = dragSrcEl.innerHTML;
    dragSrcEl.innerHTML = temp;
    addAccordionListeners(this);
    addAccordionListeners(dragSrcEl);
  }


  return false;
}

function handleDragEnd(e) {
  draggableDivs.forEach(div => div.classList.remove('dragging'));
}




function addAccordionListeners(draggableDiv) {
  const accordionBtn = draggableDiv.querySelector('.accordion');
  const contentDiv = draggableDiv.querySelector('.content');
  accordionBtn.addEventListener('click', () => {
    if (contentDiv.style.display === 'none') {
      contentDiv.style.display = 'block';
    } else {
      contentDiv.style.display = 'none';
    }
  });

  const logoGold = draggableDiv.querySelectorAll('.gold');
  const logoSilver = draggableDiv.querySelectorAll('.silver');
  const logoBronze = draggableDiv.querySelectorAll('.bronze');
  const button = draggableDiv.querySelector('button');
  button.addEventListener('click', (event) => {
    if (button.style.height === '450px'){
      button.style.maxHeight = '120px';
      button.style.height = '120px';
      button.style.textAlign = 'left';
      button.style.justifyContent = 'left';
      button.style.alignItems = 'left';
      button.classList.remove("activeButton");
      logoGold.forEach((logo) => {
        logo.style.marginTop = '50px';
      });
      logoSilver.forEach((logo) => {
        logo.style.marginTop = '50px';
      });
      logoBronze.forEach((logo) => {
        logo.style.marginTop = '50px';
      });
      contentDiv.style.display = 'none';
      
    } else {
      button.style.maxHeight = '450px';
      button.style.height = '450px';
      button.style.textAlign = 'center';
      button.style.justifyContent = 'center';
      button.classList.add("activeButton");
      logoGold.forEach((logo) => {
        logo.style.marginTop = '-15px';
      });
      logoSilver.forEach((logo) => {
        logo.style.marginTop = '20px';
      });
      logoBronze.forEach((logo) => {
        logo.style.marginTop = '20px';
      });
      contentDiv.style.display = 'block';
    }
    event.stopPropagation();
  });
}

draggableDivs.forEach(div => {
  div.addEventListener('dragstart', handleDragStart);
  div.addEventListener('dragover', handleDragOver);
  div.addEventListener('drop', handleDrop);
  div.addEventListener('dragend', handleDragEnd);

  addAccordionListeners(div);
});

// Search function to filter draggableDivs
function searchDrags(searchText) {
  draggableDivs.forEach(div => {
    const content = div.innerText.toLowerCase();
    if (content.includes(searchText.toLowerCase())) {
      div.style.display = 'block';
    } else {
      div.style.display = 'none';
    }
  });
}

function handleSearchInput() {
  const searchInput = document.getElementById('searchInput').value;
  searchDrags(searchInput);
}

document.getElementById('searchInput').addEventListener('input', handleSearchInput);




