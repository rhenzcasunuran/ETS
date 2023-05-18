// Code to connect to Firebase
// Initialize Firebase
//const firebaseConfig = {
//    // Your Firebase project configuration
//  };
//  
//  firebase.initializeApp(firebaseConfig);
//  
//  // Get a reference to the database
//  const db = firebase.firestore();
//  
// // Get a reference to the collection you want to use
//  const collectionRef = db.collection('your_collection_name');

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

  saveDivOrder();

  return false;
}

function handleDragEnd(e) {
  draggableDivs.forEach(div => div.classList.remove('dragging'));
}

// Save data to firebase - Change buttons to div
//function saveButtonOrder() {
//    const buttonOrder = [];
//    buttons.forEach(button => buttonOrder.push(button.innerHTML));
//    // Save the data to Firebase
//    collectionRef.doc('buttonOrder').set({ order: buttonOrder })
//      .then(() => console.log('Data saved'))
//      .catch((error) => console.error('Error saving data:', error));
//}

function saveDivOrder() {
  const divOrder = [];
  draggableDivs.forEach(div => divOrder.push(div.innerHTML));
  localStorage.setItem('divOrder', JSON.stringify(divOrder));
}

function loadDivOrder() {
  const divOrder = JSON.parse(localStorage.getItem('divOrder'));
  if (divOrder) {
    for (let i = 0; i < divOrder.length; i++) {
      draggableDivs[i].innerHTML = divOrder[i];
      addAccordionListeners(draggableDivs[i]);

      const eventDiv = draggableDivs[i].querySelector('.event');
      if (eventDiv) {
        eventDiv.style.display = 'none';
      }

      const buttonChange = draggableDivs[i].querySelector('button');
      if (buttonChange) {
        buttonChange.style.height = "120px";
      }
    }
  }
}

// Load from Firebase - Change the buttons to div
//function loadButtonOrder() {
//    // Load the data from Firebase
//    collectionRef.doc('buttonOrder').get()
//      .then((doc) => {
//        if (doc.exists) {
//          const buttonOrder = doc.data().order;
//          for (let i = 0; i < buttonOrder.length; i++) {
//            buttons[i].innerHTML = buttonOrder[i];
//          }
//        }
//      })
//      .catch((error) => console.error('Error loading data:', error));
//}

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
    if (button.style.height === '120px') {
      button.style.maxHeight = '450px';
      button.style.height = '450px';
      button.style.textAlign = 'center';
      button.style.justifyContent = 'center';
      button.classList.add("activeButton");
      logoGold.forEach((logo) => {
        logo.style.marginTop = '0px';
      });
      logoSilver.forEach((logo) => {
        logo.style.marginTop = '35px';
      });
      logoBronze.forEach((logo) => {
        logo.style.marginTop = '35px';
      });
    } else {
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


loadDivOrder();


