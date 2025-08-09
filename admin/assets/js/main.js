/**
 * Main
 */

'use strict';

let menu, animate;

(function () {
  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  window.Helpers.setCollapsed(true, false);
})();


function togglePasswordVisibility(fieldId) {
  const passwordField = document.getElementById(fieldId);
  const icon = passwordField.nextElementSibling.querySelector('i');
  if (passwordField.type === 'password') {
  passwordField.type = 'text';
  icon.classList.remove('bx-low-vision');
  icon.classList.add('bxs-low-vision');
  } else {
  passwordField.type = 'password';
  icon.classList.remove('bxs-low-vision');
  icon.classList.add('bx-low-vision');
  }
}

   // If using jQuery.noConflict()
   var $j = jQuery.noConflict();
   $j(document).ready(function() {
     $j('.select-multiple').select2();
   });
 

document.querySelectorAll('a.delete').forEach(link => {
    link.addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to delete this item?')) {
            e.preventDefault();
        }
    });
});


document.querySelectorAll('a.read').forEach(link => {
  link.addEventListener('click', function(e) {
      if (!confirm('Are you sure you want to mark all notifications as read?')) {
          e.preventDefault();
      }
  });
});



document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-video-module').forEach(function (button) {
    button.addEventListener('click', function () {
      const moduleId = this.getAttribute('data-module-id');

      if (!moduleId) {
        alert('Module ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this video module?')) {
        return;
      }

      fetch(`delete_image.php?action=deletevideomodule&module_id=${moduleId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        if (cleaned.includes('success')) {
          this.closest('.video-module')?.remove();
          alert('Video module deleted successfully.');
        } else {
          alert('Failed to delete video module: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-text-module').forEach(function (button) {
    button.addEventListener('click', function () {
      const moduleId = this.getAttribute('data-module-id');

      if (!moduleId) {
        alert('Module ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this text module?')) {
        return;
      }

      fetch(`delete_image.php?action=deletetextmodule&module_id=${moduleId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        if (data.trim().toLowerCase().includes('success')) {
          this.closest('.text-module')?.remove();
          alert('Text module deleted successfully.');
        } else {
          alert('Failed to delete text module: ' + data);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});


document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-video-trailer').forEach(function (button) {
    button.addEventListener('click', function () {
      const videoId = this.getAttribute('data-video-id');

      if (!videoId) {
        alert('Video ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this video?')) {
        return;
      }

      fetch(`delete_image.php?action=deletevideotrailer&video_id=${videoId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        console.log('Server response:', JSON.stringify(cleaned)); // Debug log

        if (cleaned.includes('success')) {
          this.closest('li')?.remove();
          alert('Video deleted successfully.');
        } else {
          alert('Failed to delete video: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});



document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-video-promo').forEach(function (button) {
    button.addEventListener('click', function () {
      const videoId = this.getAttribute('data-video-id');

      if (!videoId) {
        alert('Video ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this video?')) {
        return;
      }

      fetch(`delete_image.php?action=deletevideopromo&video_id=${videoId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        console.log('Server response:', JSON.stringify(cleaned)); // Debug log

        if (cleaned.includes('success')) {
          this.closest('li')?.remove();
          alert('Video deleted successfully.');
        } else {
          alert('Failed to delete video: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});

document.querySelectorAll('.delete-image').forEach(button => {
  button.addEventListener('click', function() {
      if (confirm('Are you sure you want to delete this image?')) {
          let imageId = this.getAttribute('data-image-id');
          fetch(`delete_image.php?action=deleteimage&image_id=${imageId}`, {
              method: 'GET'
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  this.closest('.image-preview').remove();
                  showToast('Image deleted successfully.');
              } else {
                  alert('Failed to delete image.');
              }
          })
          .catch(error => {
              console.error('Error deleting image:', error);
          });
      }
  });
});

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-video-lesson').forEach(function (button) {
    button.addEventListener('click', function () {
      const videoId = this.getAttribute('data-video-id');

      if (!videoId) {
        alert('Video ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this video?')) {
        return;
      }

      fetch(`delete_image.php?action=deletevideo&video_id=${videoId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        console.log('Server response:', JSON.stringify(cleaned)); // Debug log

        if (cleaned.includes('success')) {
          this.closest('li')?.remove(); // Remove the <li> that contains the video
          alert('Video deleted successfully.');
        } else {
          alert('Failed to delete video: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-quiz-file').forEach(function (button) {
    button.addEventListener('click', function () {
      const quizId = this.getAttribute('data-quiz-id');

      if (!quizId) {
        alert('Quiz file ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this file?')) {
        return;
      }

      fetch(`delete_image.php?action=deletequizfile&quiz_id=${quizId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        console.log('Server response:', JSON.stringify(cleaned));

        if (cleaned.includes('success')) {
          this.closest('li')?.remove();
          alert('File deleted successfully.');
        } else {
          alert('Failed to delete file: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while deleting the file.');
      });
    });
  });
});


document.querySelectorAll('.delete-promo-video').forEach(button => {
  button.addEventListener('click', function() {
      if (confirm('Are you sure you want to delete this file?')) {
          let imageId = this.getAttribute('data-image-id');
          fetch(`delete_image.php?action=deletepromovideo&image_id=${imageId}`, {
              method: 'GET'
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  this.closest('.file-preview').remove();
                  showToast('File deleted successfully.');
              } else {
                  alert('Failed to delete file.');
              }
          })
          .catch(error => {
              console.error('Error deleting file:', error);
          });
      }
  });
});

document.querySelectorAll('.delete-quiz-file').forEach(button => {
  button.addEventListener('click', function () {
    if (confirm('Are you sure you want to delete this quiz file?')) {
      const file = this.getAttribute('data-file');
      const trainingId = this.getAttribute('data-id');
      const listItem = this.closest('li');

      fetch(`delete_image.php?action=deletequizfile&training_id=${trainingId}&file=${encodeURIComponent(file)}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            listItem.remove();
            showToast('Quiz file deleted.');
          } else {
            alert('Error: ' + (data.message || 'Could not delete file.'));
          }
        })
        .catch(err => {
          console.error('Fetch error:', err);
        });
    }
  });
});


document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.delete-text-module').forEach(function (button) {
    button.addEventListener('click', function () {
      const textId = this.getAttribute('data-id');

      if (!textId) {
        alert('Text ID not found.');
        return;
      }

      if (!confirm('Are you sure you want to delete this document?')) {
        return;
      }

      fetch(`delete_image.php?action=deletetext&text_id=${textId}`, {
        method: 'GET',
      })
      .then(response => response.text())
      .then(data => {
        const cleaned = data.trim().toLowerCase();
        console.log('Server response:', JSON.stringify(cleaned)); // Debug

        if (cleaned.includes('success')) {
          this.closest('li')?.remove(); // Remove <li> containing the button
          alert('Text module deleted successfully.');
        } else {
          alert('Failed to delete text module: ' + cleaned);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred.');
      });
    });
  });
});



document.addEventListener('DOMContentLoaded', function () {
      const stateAndLGAs = {
    "Abia": [
        "Aba North",
        "Aba South",
        "Arochukwu",
        "Bende",
        "Ikwuano",
        "Isiala-Ngwa North",
        "Isiala-Ngwa South",
        "Isuikwato",
        "Obi Nwa",
        "Ohafia",
        "Osisioma",
        "Ngwa",
        "Ugwunagbo",
        "Ukwa East",
        "Ukwa West",
        "Umuahia North",
        "Umuahia South",
        "Umu-Neochi"
    ],
		 "Adamawa": [
        "Demsa",
        "Fufore",
        "Ganaye",
        "Gireri",
        "Gombi",
        "Guyuk",
        "Hong",
        "Jada",
        "Lamurde",
        "Madagali",
        "Maiha",
        "Mayo-Belwa",
        "Michika",
        "Mubi North",
        "Mubi South",
        "Numan",
        "Shelleng",
        "Song",
        "Toungo",
        "Yola North",
        "Yola South"
    ],
    "Anambra": [
        "Aguata",
        "Anambra East",
        "Anambra West",
        "Anaocha",
        "Awka North",
        "Awka South",
        "Ayamelum",
        "Dunukofia",
        "Ekwusigo",
        "Idemili North",
        "Idemili south",
        "Ihiala",
        "Njikoka",
        "Nnewi North",
        "Nnewi South",
        "Ogbaru",
        "Onitsha North",
        "Onitsha South",
        "Orumba North",
        "Orumba South",
        "Oyi"
    ],
    "Akwa Ibom": [
        "Abak",
        "Eastern Obolo",
        "Eket",
        "Esit Eket",
        "Essien Udim",
        "Etim Ekpo",
        "Etinan",
        "Ibeno",
        "Ibesikpo Asutan",
        "Ibiono Ibom",
        "Ika",
        "Ikono",
        "Ikot Abasi",
        "Ikot Ekpene",
        "Ini",
        "Itu",
        "Mbo",
        "Mkpat Enin",
        "Nsit Atai",
        "Nsit Ibom",
        "Nsit Ubium",
        "Obot Akara",
        "Okobo",
        "Onna",
        "Oron",
        "Oruk Anam",
        "Udung Uko",
        "Ukanafun",
        "Uruan",
        "Urue-Offong/Oruko ",
        "Uyo"
    ],
    "Bauchi": [
        "Alkaleri",
        "Bauchi",
        "Bogoro",
        "Damban",
        "Darazo",
        "Dass",
        "Ganjuwa",
        "Giade",
        "Itas/Gadau",
        "Jama'are",
        "Katagum",
        "Kirfi",
        "Misau",
        "Ningi",
        "Shira",
        "Tafawa-Balewa",
        "Toro",
        "Warji",
        "Zaki"
    ],
    "Bayelsa": [
        "Brass",
        "Ekeremor",
        "Kolokuma/Opokuma",
        "Nembe",
        "Ogbia",
        "Sagbama",
        "Southern Jaw",
        "Yenegoa"
    ],
    "Benue": [
        "Ado",
        "Agatu",
        "Apa",
        "Buruku",
        "Gboko",
        "Guma",
        "Gwer East",
        "Gwer West",
        "Katsina-Ala",
        "Konshisha",
        "Kwande",
        "Logo",
        "Makurdi",
        "Obi",
        "Ogbadibo",
        "Oju",
        "Okpokwu",
        "Ohimini",
        "Oturkpo",
        "Tarka",
        "Ukum",
        "Ushongo",
        "Vandeikya"
    ],
    "Borno": [
        "Abadam",
        "Askira/Uba",
        "Bama",
        "Bayo",
        "Biu",
        "Chibok",
        "Damboa",
        "Dikwa",
        "Gubio",
        "Guzamala",
        "Gwoza",
        "Hawul",
        "Jere",
        "Kaga",
        "Kala/Balge",
        "Konduga",
        "Kukawa",
        "Kwaya Kusar",
        "Mafa",
        "Magumeri",
        "Maiduguri",
        "Marte",
        "Mobbar",
        "Monguno",
        "Ngala",
        "Nganzai",
        "Shani"
    ],
    "Cross River": [
        "Akpabuyo",
        "Odukpani",
        "Akamkpa",
        "Biase",
        "Abi",
        "Ikom",
        "Yarkur",
        "Odubra",
        "Boki",
        "Ogoja",
        "Yala",
        "Obanliku",
        "Obudu",
        "Calabar South",
        "Etung",
        "Bekwara",
        "Bakassi",
        "Calabar Municipality"
    ],
    "Delta": [
        "Oshimili",
        "Aniocha",
        "Aniocha South",
        "Ika South",
        "Ika North-East",
        "Ndokwa West",
        "Ndokwa East",
        "Isoko south",
        "Isoko North",
        "Bomadi",
        "Burutu",
        "Ughelli South",
        "Ughelli North",
        "Ethiope West",
        "Ethiope East",
        "Sapele",
        "Okpe",
        "Warri North",
        "Warri South",
        "Uvwie",
        "Udu",
        "Warri Central",
        "Ukwani",
        "Oshimili North",
        "Patani"
    ],
    "Ebonyi": [
        "Edda",
        "Afikpo",
        "Onicha",
        "Ohaozara",
        "Abakaliki",
        "Ishielu",
        "lkwo",
        "Ezza",
        "Ezza South",
        "Ohaukwu",
        "Ebonyi",
        "Ivo"
    ],
    "Enugu": [
        "Enugu South,",
        "Igbo-Eze South",
        "Enugu North",
        "Nkanu",
        "Udi Agwu",
        "Oji-River",
        "Ezeagu",
        "IgboEze North",
        "Isi-Uzo",
        "Nsukka",
        "Igbo-Ekiti",
        "Uzo-Uwani",
        "Enugu Eas",
        "Aninri",
        "Nkanu East",
        "Udenu."
    ],
    "Edo": [
        "Esan North-East",
        "Esan Central",
        "Esan West",
        "Egor",
        "Ukpoba",
        "Central",
        "Etsako Central",
        "Igueben",
        "Oredo",
        "Ovia SouthWest",
        "Ovia South-East",
        "Orhionwon",
        "Uhunmwonde",
        "Etsako East",
        "Esan South-East"
    ],
    "Ekiti": [
        "Ado",
        "Ekiti-East",
        "Ekiti-West",
        "Emure/Ise/Orun",
        "Ekiti South-West",
        "Ikere",
        "Irepodun",
        "Ijero,",
        "Ido/Osi",
        "Oye",
        "Ikole",
        "Moba",
        "Gbonyin",
        "Efon",
        "Ise/Orun",
        "Ilejemeje."
    ],
    "FCT": [
        "Abaji",
        "Abuja Municipal",
        "Bwari",
        "Gwagwalada",
        "Kuje",
        "Kwali"
    ],
    "Gombe": [
        "Akko",
        "Balanga",
        "Billiri",
        "Dukku",
        "Kaltungo",
        "Kwami",
        "Shomgom",
        "Funakaye",
        "Gombe",
        "Nafada/Bajoga",
        "Yamaltu/Delta."
    ],
    "Imo": [
        "Aboh-Mbaise",
        "Ahiazu-Mbaise",
        "Ehime-Mbano",
        "Ezinihitte",
        "Ideato North",
        "Ideato South",
        "Ihitte/Uboma",
        "Ikeduru",
        "Isiala Mbano",
        "Isu",
        "Mbaitoli",
        "Mbaitoli",
        "Ngor-Okpala",
        "Njaba",
        "Nwangele",
        "Nkwerre",
        "Obowo",
        "Oguta",
        "Ohaji/Egbema",
        "Okigwe",
        "Orlu",
        "Orsu",
        "Oru East",
        "Oru West",
        "Owerri-Municipal",
        "Owerri North",
        "Owerri West"
    ],
    "Jigawa": [
        "Auyo",
        "Babura",
        "Birni Kudu",
        "Biriniwa",
        "Buji",
        "Dutse",
        "Gagarawa",
        "Garki",
        "Gumel",
        "Guri",
        "Gwaram",
        "Gwiwa",
        "Hadejia",
        "Jahun",
        "Kafin Hausa",
        "Kaugama Kazaure",
        "Kiri Kasamma",
        "Kiyawa",
        "Maigatari",
        "Malam Madori",
        "Miga",
        "Ringim",
        "Roni",
        "Sule-Tankarkar",
        "Taura",
        "Yankwashi"
    ],
    "Kaduna": [
        "Birni-Gwari",
        "Chikun",
        "Giwa",
        "Igabi",
        "Ikara",
        "jaba",
        "Jema'a",
        "Kachia",
        "Kaduna North",
        "Kaduna South",
        "Kagarko",
        "Kajuru",
        "Kaura",
        "Kauru",
        "Kubau",
        "Kudan",
        "Lere",
        "Makarfi",
        "Sabon-Gari",
        "Sanga",
        "Soba",
        "Zango-Kataf",
        "Zaria"
    ],
    "Kano": [
        "Ajingi",
        "Albasu",
        "Bagwai",
        "Bebeji",
        "Bichi",
        "Bunkure",
        "Dala",
        "Dambatta",
        "Dawakin Kudu",
        "Dawakin Tofa",
        "Doguwa",
        "Fagge",
        "Gabasawa",
        "Garko",
        "Garum",
        "Mallam",
        "Gaya",
        "Gezawa",
        "Gwale",
        "Gwarzo",
        "Kabo",
        "Kano Municipal",
        "Karaye",
        "Kibiya",
        "Kiru",
        "kumbotso",
        "Ghari",
        "Kura",
        "Madobi",
        "Makoda",
        "Minjibir",
        "Nasarawa",
        "Rano",
        "Rimin Gado",
        "Rogo",
        "Shanono",
        "Sumaila",
        "Takali",
        "Tarauni",
        "Tofa",
        "Tsanyawa",
        "Tudun Wada",
        "Ungogo",
        "Warawa",
        "Wudil"
    ],
    "Katsina": [
        "Bakori",
        "Batagarawa",
        "Batsari",
        "Baure",
        "Bindawa",
        "Charanchi",
        "Dandume",
        "Danja",
        "Dan Musa",
        "Daura",
        "Dutsi",
        "Dutsin-Ma",
        "Faskari",
        "Funtua",
        "Ingawa",
        "Jibia",
        "Kafur",
        "Kaita",
        "Kankara",
        "Kankia",
        "Katsina",
        "Kurfi",
        "Kusada",
        "Mai'Adua",
        "Malumfashi",
        "Mani",
        "Mashi",
        "Matazuu",
        "Musawa",
        "Rimi",
        "Sabuwa",
        "Safana",
        "Sandamu",
        "Zango"
    ],
    "Kebbi": [
        "Aleiro",
        "Arewa-Dandi",
        "Argungu",
        "Augie",
        "Bagudo",
        "Birnin Kebbi",
        "Bunza",
        "Dandi",
        "Fakai",
        "Gwandu",
        "Jega",
        "Kalgo",
        "Koko/Besse",
        "Maiyama",
        "Ngaski",
        "Sakaba",
        "Shanga",
        "Suru",
        "Wasagu/Danko",
        "Yauri",
        "Zuru"
    ],
    "Kogi": [
        "Adavi",
        "Ajaokuta",
        "Ankpa",
        "Bassa",
        "Dekina",
        "Ibaji",
        "Idah",
        "Igalamela-Odolu",
        "Ijumu",
        "Kabba/Bunu",
        "Kogi",
        "Lokoja",
        "Mopa-Muro",
        "Ofu",
        "Ogori/Mangongo",
        "Okehi",
        "Okene",
        "Olamabolo",
        "Omala",
        "Yagba East",
        "Yagba West"
    ],
    "Kwara": [
        "Asa",
        "Baruten",
        "Edu",
        "Ekiti",
        "Ifelodun",
        "Ilorin East",
        "Ilorin West",
        "Irepodun",
        "Isin",
        "Kaiama",
        "Moro",
        "Offa",
        "Oke-Ero",
        "Oyun",
        "Pategi"
    ],
    "Lagos": [
        "Agege",
        "Ajeromi-Ifelodun",
        "Alimosho",
        "Amuwo-Odofin",
        "Apapa",
        "Badagry",
        "Epe",
        "Eti-Osa",
        "Ibeju/Lekki",
        "Ifako-Ijaye",
        "Ikeja",
        "Ikorodu",
        "Kosofe",
        "Lagos Island",
        "Lagos Mainland",
        "Mushin",
        "Ojo",
        "Oshodi-Isolo",
        "Shomolu",
        "Surulere"
    ],
    "Nasarawa": [
        "Akwanga",
        "Awe",
        "Doma",
        "Karu",
        "Keana",
        "Keffi",
        "Kokona",
        "Lafia",
        "Nasarawa",
        "Nasarawa-Eggon",
        "Obi",
        "Toto",
        "Wamba"
    ],
    "Niger": [
        "Agaie",
        "Agwara",
        "Bida",
        "Borgu",
        "Bosso",
        "Chanchaga",
        "Edati",
        "Gbako",
        "Gurara",
        "Katcha",
        "Kontagora",
        "Lapai",
        "Lavun",
        "Magama",
        "Mariga",
        "Mashegu",
        "Mokwa",
        "Muya",
        "Pailoro",
        "Rafi",
        "Rijau",
        "Shiroro",
        "Suleja",
        "Tafa",
        "Wushishi"
    ],
    "Ogun": [
        "Abeokuta North",
        "Abeokuta South",
        "Ado-Odo/Ota",
        "Yewa North",
        "Yewa South",
        "Ewekoro",
        "Ifo",
        "Ijebu East",
        "Ijebu North",
        "Ijebu North East",
        "Ijebu Ode",
        "Ikenne",
        "Imeko-Afon",
        "Ipokia",
        "Obafemi-Owode",
        "Ogun Waterside",
        "Odeda",
        "Odogbolu",
        "Remo North",
        "Shagamu"
    ],
    "Ondo": [
        "Akoko North East",
        "Akoko North West",
        "Akoko South Akure East",
        "Akoko South West",
        "Akure North",
        "Akure South",
        "Ese-Odo",
        "Idanre",
        "Ifedore",
        "Ilaje",
        "Ile-Oluji",
        "Okeigbo",
        "Irele",
        "Odigbo",
        "Okitipupa",
        "Ondo East",
        "Ondo West",
        "Ose",
        "Owo"
    ],
    "Osun": [
        "Aiyedade",
        "Aiyedire",
        "Atakumosa East",
        "Atakumosa West",
        "Boluwaduro",
        "Boripe",
        "Ede North",
        "Ede South",
        "Egbedore",
        "Ejigbo",
        "Ife Central",
        "Ife East",
        "Ife North",
        "Ife South",
        "Ifedayo",
        "Ifelodun",
        "Ila",
        "Ilesha East",
        "Ilesha West",
        "Irepodun",
        "Irewole",
        "Isokan",
        "Iwo",
        "Obokun",
        "Odo-Otin",
        "Ola-Oluwa",
        "Olorunda",
        "Oriade",
        "Orolu",
        "Osogbo"
    ],
    "Oyo": [
        "Afijio",
        "Akinyele",
        "Atiba",
        "Atisbo",
        "Egbeda",
        "Ibadan Central",
        "Ibadan North",
        "Ibadan North West",
        "Ibadan South East",
        "Ibadan South West",
        "Ibarapa Central",
        "Ibarapa East",
        "Ibarapa North",
        "Ido",
        "Irepo",
        "Iseyin",
        "Itesiwaju",
        "Iwajowa",
        "Kajola",
        "Lagelu Ogbomosho North",
        "Ogbomosho South",
        "Ogo Oluwa",
        "Olorunsogo",
        "Oluyole",
        "Ona-Ara",
        "Orelope",
        "Ori Ire",
        "Oyo East",
        "Oyo West",
        "Saki East",
        "Saki West",
        "Surulere"
    ],
    "Plateau": [
        "Barikin Ladi",
        "Bassa",
        "Bokkos",
        "Jos East",
        "Jos North",
        "Jos South",
        "Kanam",
        "Kanke",
        "Langtang North",
        "Langtang South",
        "Mangu",
        "Mikang",
        "Pankshin",
        "Qua'an Pan",
        "Riyom",
        "Shendam",
        "Wase"
    ],
    "Rivers": [
        "Abua/Odual",
        "Ahoada East",
        "Ahoada West",
        "Akuku Toru",
        "Andoni",
        "Asari-Toru",
        "Bonny",
        "Degema",
        "Emohua",
        "Eleme",
        "Etche",
        "Gokana",
        "Ikwerre",
        "Khana",
        "Obio/Akpor",
        "Ogba/Egbema/Ndoni",
        "Ogu/Bolo",
        "Okrika",
        "Omumma",
        "Opobo/Nkoro",
        "Oyigbo",
        "Port-Harcourt",
        "Tai"
    ],
    "Sokoto": [
        "Binji",
        "Bodinga",
        "Dange-shnsi",
        "Gada",
        "Goronyo",
        "Gudu",
        "Gawabawa",
        "Illela",
        "Isa",
        "Kware",
        "kebbe",
        "Rabah",
        "Sabon birni",
        "Shagari",
        "Silame",
        "Sokoto North",
        "Sokoto South",
        "Tambuwal",
        "Tqngaza",
        "Tureta",
        "Wamako",
        "Wurno",
        "Yabo"
    ],
    "Taraba": [
        "Ardo-kola",
        "Bali",
        "Donga",
        "Gashaka",
        "Cassol",
        "Ibi",
        "Jalingo",
        "Karin-Lamido",
        "Kurmi",
        "Lau",
        "Sardauna",
        "Takum",
        "Ussa",
        "Wukari",
        "Yorro",
        "Zing"
    ],
    "Yobe": [
        "Bade",
        "Bursari",
        "Damaturu",
        "Fika",
        "Fune",
        "Geidam",
        "Gujba",
        "Gulani",
        "Jakusko",
        "Karasuwa",
        "Karawa",
        "Machina",
        "Nangere",
        "Nguru Potiskum",
        "Tarmua",
        "Yunusari",
        "Yusufari"
    ],
    "Zamfara": [
        "Anka",
        "Bakura",
        "Birnin Magaji",
        "Bukkuyum",
        "Bungudu",
        "Gummi",
        "Gusau",
        "Kaura",
        "Namoda",
        "Maradun",
        "Maru",
        "Shinkafi",
        "Talata Mafara",
        "Tsafe",
        "Zurmi"
    ]
      };

      const stateSelect = document.getElementById('state');
      const lgaSelect = document.getElementById('lga');

      // Populate states
      Object.keys(stateAndLGAs).forEach(state => {
        const option = document.createElement('option');
        option.value = state;
        option.textContent = state;
        stateSelect.appendChild(option);
      });

      // Populate LGAs when state is selected
      stateSelect.addEventListener('change', function () {
        const selectedState = this.value;
        lgaSelect.innerHTML = '<option value="">-- Select LGA --</option>';

        if (stateAndLGAs[selectedState]) {
          stateAndLGAs[selectedState].forEach(lga => {
            const option = document.createElement('option');
            option.value = lga;
            option.textContent = lga;
            lgaSelect.appendChild(option);
          });
        }
      });
    });


    
document.addEventListener('DOMContentLoaded', function () {
      const stateAndLGAs = {
    "Abia": [
        "Aba North",
        "Aba South",
        "Arochukwu",
        "Bende",
        "Ikwuano",
        "Isiala-Ngwa North",
        "Isiala-Ngwa South",
        "Isuikwato",
        "Obi Nwa",
        "Ohafia",
        "Osisioma",
        "Ngwa",
        "Ugwunagbo",
        "Ukwa East",
        "Ukwa West",
        "Umuahia North",
        "Umuahia South",
        "Umu-Neochi"
    ],
		 "Adamawa": [
        "Demsa",
        "Fufore",
        "Ganaye",
        "Gireri",
        "Gombi",
        "Guyuk",
        "Hong",
        "Jada",
        "Lamurde",
        "Madagali",
        "Maiha",
        "Mayo-Belwa",
        "Michika",
        "Mubi North",
        "Mubi South",
        "Numan",
        "Shelleng",
        "Song",
        "Toungo",
        "Yola North",
        "Yola South"
    ],
    "Anambra": [
        "Aguata",
        "Anambra East",
        "Anambra West",
        "Anaocha",
        "Awka North",
        "Awka South",
        "Ayamelum",
        "Dunukofia",
        "Ekwusigo",
        "Idemili North",
        "Idemili south",
        "Ihiala",
        "Njikoka",
        "Nnewi North",
        "Nnewi South",
        "Ogbaru",
        "Onitsha North",
        "Onitsha South",
        "Orumba North",
        "Orumba South",
        "Oyi"
    ],
    "Akwa Ibom": [
        "Abak",
        "Eastern Obolo",
        "Eket",
        "Esit Eket",
        "Essien Udim",
        "Etim Ekpo",
        "Etinan",
        "Ibeno",
        "Ibesikpo Asutan",
        "Ibiono Ibom",
        "Ika",
        "Ikono",
        "Ikot Abasi",
        "Ikot Ekpene",
        "Ini",
        "Itu",
        "Mbo",
        "Mkpat Enin",
        "Nsit Atai",
        "Nsit Ibom",
        "Nsit Ubium",
        "Obot Akara",
        "Okobo",
        "Onna",
        "Oron",
        "Oruk Anam",
        "Udung Uko",
        "Ukanafun",
        "Uruan",
        "Urue-Offong/Oruko ",
        "Uyo"
    ],
    "Bauchi": [
        "Alkaleri",
        "Bauchi",
        "Bogoro",
        "Damban",
        "Darazo",
        "Dass",
        "Ganjuwa",
        "Giade",
        "Itas/Gadau",
        "Jama'are",
        "Katagum",
        "Kirfi",
        "Misau",
        "Ningi",
        "Shira",
        "Tafawa-Balewa",
        "Toro",
        "Warji",
        "Zaki"
    ],
    "Bayelsa": [
        "Brass",
        "Ekeremor",
        "Kolokuma/Opokuma",
        "Nembe",
        "Ogbia",
        "Sagbama",
        "Southern Jaw",
        "Yenegoa"
    ],
    "Benue": [
        "Ado",
        "Agatu",
        "Apa",
        "Buruku",
        "Gboko",
        "Guma",
        "Gwer East",
        "Gwer West",
        "Katsina-Ala",
        "Konshisha",
        "Kwande",
        "Logo",
        "Makurdi",
        "Obi",
        "Ogbadibo",
        "Oju",
        "Okpokwu",
        "Ohimini",
        "Oturkpo",
        "Tarka",
        "Ukum",
        "Ushongo",
        "Vandeikya"
    ],
    "Borno": [
        "Abadam",
        "Askira/Uba",
        "Bama",
        "Bayo",
        "Biu",
        "Chibok",
        "Damboa",
        "Dikwa",
        "Gubio",
        "Guzamala",
        "Gwoza",
        "Hawul",
        "Jere",
        "Kaga",
        "Kala/Balge",
        "Konduga",
        "Kukawa",
        "Kwaya Kusar",
        "Mafa",
        "Magumeri",
        "Maiduguri",
        "Marte",
        "Mobbar",
        "Monguno",
        "Ngala",
        "Nganzai",
        "Shani"
    ],
    "Cross River": [
        "Akpabuyo",
        "Odukpani",
        "Akamkpa",
        "Biase",
        "Abi",
        "Ikom",
        "Yarkur",
        "Odubra",
        "Boki",
        "Ogoja",
        "Yala",
        "Obanliku",
        "Obudu",
        "Calabar South",
        "Etung",
        "Bekwara",
        "Bakassi",
        "Calabar Municipality"
    ],
    "Delta": [
        "Oshimili",
        "Aniocha",
        "Aniocha South",
        "Ika South",
        "Ika North-East",
        "Ndokwa West",
        "Ndokwa East",
        "Isoko south",
        "Isoko North",
        "Bomadi",
        "Burutu",
        "Ughelli South",
        "Ughelli North",
        "Ethiope West",
        "Ethiope East",
        "Sapele",
        "Okpe",
        "Warri North",
        "Warri South",
        "Uvwie",
        "Udu",
        "Warri Central",
        "Ukwani",
        "Oshimili North",
        "Patani"
    ],
    "Ebonyi": [
        "Edda",
        "Afikpo",
        "Onicha",
        "Ohaozara",
        "Abakaliki",
        "Ishielu",
        "lkwo",
        "Ezza",
        "Ezza South",
        "Ohaukwu",
        "Ebonyi",
        "Ivo"
    ],
    "Enugu": [
        "Enugu South,",
        "Igbo-Eze South",
        "Enugu North",
        "Nkanu",
        "Udi Agwu",
        "Oji-River",
        "Ezeagu",
        "IgboEze North",
        "Isi-Uzo",
        "Nsukka",
        "Igbo-Ekiti",
        "Uzo-Uwani",
        "Enugu Eas",
        "Aninri",
        "Nkanu East",
        "Udenu."
    ],
    "Edo": [
        "Esan North-East",
        "Esan Central",
        "Esan West",
        "Egor",
        "Ukpoba",
        "Central",
        "Etsako Central",
        "Igueben",
        "Oredo",
        "Ovia SouthWest",
        "Ovia South-East",
        "Orhionwon",
        "Uhunmwonde",
        "Etsako East",
        "Esan South-East"
    ],
    "Ekiti": [
        "Ado",
        "Ekiti-East",
        "Ekiti-West",
        "Emure/Ise/Orun",
        "Ekiti South-West",
        "Ikere",
        "Irepodun",
        "Ijero,",
        "Ido/Osi",
        "Oye",
        "Ikole",
        "Moba",
        "Gbonyin",
        "Efon",
        "Ise/Orun",
        "Ilejemeje."
    ],
    "FCT": [
        "Abaji",
        "Abuja Municipal",
        "Bwari",
        "Gwagwalada",
        "Kuje",
        "Kwali"
    ],
    "Gombe": [
        "Akko",
        "Balanga",
        "Billiri",
        "Dukku",
        "Kaltungo",
        "Kwami",
        "Shomgom",
        "Funakaye",
        "Gombe",
        "Nafada/Bajoga",
        "Yamaltu/Delta."
    ],
    "Imo": [
        "Aboh-Mbaise",
        "Ahiazu-Mbaise",
        "Ehime-Mbano",
        "Ezinihitte",
        "Ideato North",
        "Ideato South",
        "Ihitte/Uboma",
        "Ikeduru",
        "Isiala Mbano",
        "Isu",
        "Mbaitoli",
        "Mbaitoli",
        "Ngor-Okpala",
        "Njaba",
        "Nwangele",
        "Nkwerre",
        "Obowo",
        "Oguta",
        "Ohaji/Egbema",
        "Okigwe",
        "Orlu",
        "Orsu",
        "Oru East",
        "Oru West",
        "Owerri-Municipal",
        "Owerri North",
        "Owerri West"
    ],
    "Jigawa": [
        "Auyo",
        "Babura",
        "Birni Kudu",
        "Biriniwa",
        "Buji",
        "Dutse",
        "Gagarawa",
        "Garki",
        "Gumel",
        "Guri",
        "Gwaram",
        "Gwiwa",
        "Hadejia",
        "Jahun",
        "Kafin Hausa",
        "Kaugama Kazaure",
        "Kiri Kasamma",
        "Kiyawa",
        "Maigatari",
        "Malam Madori",
        "Miga",
        "Ringim",
        "Roni",
        "Sule-Tankarkar",
        "Taura",
        "Yankwashi"
    ],
    "Kaduna": [
        "Birni-Gwari",
        "Chikun",
        "Giwa",
        "Igabi",
        "Ikara",
        "jaba",
        "Jema'a",
        "Kachia",
        "Kaduna North",
        "Kaduna South",
        "Kagarko",
        "Kajuru",
        "Kaura",
        "Kauru",
        "Kubau",
        "Kudan",
        "Lere",
        "Makarfi",
        "Sabon-Gari",
        "Sanga",
        "Soba",
        "Zango-Kataf",
        "Zaria"
    ],
    "Kano": [
        "Ajingi",
        "Albasu",
        "Bagwai",
        "Bebeji",
        "Bichi",
        "Bunkure",
        "Dala",
        "Dambatta",
        "Dawakin Kudu",
        "Dawakin Tofa",
        "Doguwa",
        "Fagge",
        "Gabasawa",
        "Garko",
        "Garum",
        "Mallam",
        "Gaya",
        "Gezawa",
        "Gwale",
        "Gwarzo",
        "Kabo",
        "Kano Municipal",
        "Karaye",
        "Kibiya",
        "Kiru",
        "kumbotso",
        "Ghari",
        "Kura",
        "Madobi",
        "Makoda",
        "Minjibir",
        "Nasarawa",
        "Rano",
        "Rimin Gado",
        "Rogo",
        "Shanono",
        "Sumaila",
        "Takali",
        "Tarauni",
        "Tofa",
        "Tsanyawa",
        "Tudun Wada",
        "Ungogo",
        "Warawa",
        "Wudil"
    ],
    "Katsina": [
        "Bakori",
        "Batagarawa",
        "Batsari",
        "Baure",
        "Bindawa",
        "Charanchi",
        "Dandume",
        "Danja",
        "Dan Musa",
        "Daura",
        "Dutsi",
        "Dutsin-Ma",
        "Faskari",
        "Funtua",
        "Ingawa",
        "Jibia",
        "Kafur",
        "Kaita",
        "Kankara",
        "Kankia",
        "Katsina",
        "Kurfi",
        "Kusada",
        "Mai'Adua",
        "Malumfashi",
        "Mani",
        "Mashi",
        "Matazuu",
        "Musawa",
        "Rimi",
        "Sabuwa",
        "Safana",
        "Sandamu",
        "Zango"
    ],
    "Kebbi": [
        "Aleiro",
        "Arewa-Dandi",
        "Argungu",
        "Augie",
        "Bagudo",
        "Birnin Kebbi",
        "Bunza",
        "Dandi",
        "Fakai",
        "Gwandu",
        "Jega",
        "Kalgo",
        "Koko/Besse",
        "Maiyama",
        "Ngaski",
        "Sakaba",
        "Shanga",
        "Suru",
        "Wasagu/Danko",
        "Yauri",
        "Zuru"
    ],
    "Kogi": [
        "Adavi",
        "Ajaokuta",
        "Ankpa",
        "Bassa",
        "Dekina",
        "Ibaji",
        "Idah",
        "Igalamela-Odolu",
        "Ijumu",
        "Kabba/Bunu",
        "Kogi",
        "Lokoja",
        "Mopa-Muro",
        "Ofu",
        "Ogori/Mangongo",
        "Okehi",
        "Okene",
        "Olamabolo",
        "Omala",
        "Yagba East",
        "Yagba West"
    ],
    "Kwara": [
        "Asa",
        "Baruten",
        "Edu",
        "Ekiti",
        "Ifelodun",
        "Ilorin East",
        "Ilorin West",
        "Irepodun",
        "Isin",
        "Kaiama",
        "Moro",
        "Offa",
        "Oke-Ero",
        "Oyun",
        "Pategi"
    ],
    "Lagos": [
        "Agege",
        "Ajeromi-Ifelodun",
        "Alimosho",
        "Amuwo-Odofin",
        "Apapa",
        "Badagry",
        "Epe",
        "Eti-Osa",
        "Ibeju/Lekki",
        "Ifako-Ijaye",
        "Ikeja",
        "Ikorodu",
        "Kosofe",
        "Lagos Island",
        "Lagos Mainland",
        "Mushin",
        "Ojo",
        "Oshodi-Isolo",
        "Shomolu",
        "Surulere"
    ],
    "Nasarawa": [
        "Akwanga",
        "Awe",
        "Doma",
        "Karu",
        "Keana",
        "Keffi",
        "Kokona",
        "Lafia",
        "Nasarawa",
        "Nasarawa-Eggon",
        "Obi",
        "Toto",
        "Wamba"
    ],
    "Niger": [
        "Agaie",
        "Agwara",
        "Bida",
        "Borgu",
        "Bosso",
        "Chanchaga",
        "Edati",
        "Gbako",
        "Gurara",
        "Katcha",
        "Kontagora",
        "Lapai",
        "Lavun",
        "Magama",
        "Mariga",
        "Mashegu",
        "Mokwa",
        "Muya",
        "Pailoro",
        "Rafi",
        "Rijau",
        "Shiroro",
        "Suleja",
        "Tafa",
        "Wushishi"
    ],
    "Ogun": [
        "Abeokuta North",
        "Abeokuta South",
        "Ado-Odo/Ota",
        "Yewa North",
        "Yewa South",
        "Ewekoro",
        "Ifo",
        "Ijebu East",
        "Ijebu North",
        "Ijebu North East",
        "Ijebu Ode",
        "Ikenne",
        "Imeko-Afon",
        "Ipokia",
        "Obafemi-Owode",
        "Ogun Waterside",
        "Odeda",
        "Odogbolu",
        "Remo North",
        "Shagamu"
    ],
    "Ondo": [
        "Akoko North East",
        "Akoko North West",
        "Akoko South Akure East",
        "Akoko South West",
        "Akure North",
        "Akure South",
        "Ese-Odo",
        "Idanre",
        "Ifedore",
        "Ilaje",
        "Ile-Oluji",
        "Okeigbo",
        "Irele",
        "Odigbo",
        "Okitipupa",
        "Ondo East",
        "Ondo West",
        "Ose",
        "Owo"
    ],
    "Osun": [
        "Aiyedade",
        "Aiyedire",
        "Atakumosa East",
        "Atakumosa West",
        "Boluwaduro",
        "Boripe",
        "Ede North",
        "Ede South",
        "Egbedore",
        "Ejigbo",
        "Ife Central",
        "Ife East",
        "Ife North",
        "Ife South",
        "Ifedayo",
        "Ifelodun",
        "Ila",
        "Ilesha East",
        "Ilesha West",
        "Irepodun",
        "Irewole",
        "Isokan",
        "Iwo",
        "Obokun",
        "Odo-Otin",
        "Ola-Oluwa",
        "Olorunda",
        "Oriade",
        "Orolu",
        "Osogbo"
    ],
    "Oyo": [
        "Afijio",
        "Akinyele",
        "Atiba",
        "Atisbo",
        "Egbeda",
        "Ibadan Central",
        "Ibadan North",
        "Ibadan North West",
        "Ibadan South East",
        "Ibadan South West",
        "Ibarapa Central",
        "Ibarapa East",
        "Ibarapa North",
        "Ido",
        "Irepo",
        "Iseyin",
        "Itesiwaju",
        "Iwajowa",
        "Kajola",
        "Lagelu Ogbomosho North",
        "Ogbomosho South",
        "Ogo Oluwa",
        "Olorunsogo",
        "Oluyole",
        "Ona-Ara",
        "Orelope",
        "Ori Ire",
        "Oyo East",
        "Oyo West",
        "Saki East",
        "Saki West",
        "Surulere"
    ],
    "Plateau": [
        "Barikin Ladi",
        "Bassa",
        "Bokkos",
        "Jos East",
        "Jos North",
        "Jos South",
        "Kanam",
        "Kanke",
        "Langtang North",
        "Langtang South",
        "Mangu",
        "Mikang",
        "Pankshin",
        "Qua'an Pan",
        "Riyom",
        "Shendam",
        "Wase"
    ],
    "Rivers": [
        "Abua/Odual",
        "Ahoada East",
        "Ahoada West",
        "Akuku Toru",
        "Andoni",
        "Asari-Toru",
        "Bonny",
        "Degema",
        "Emohua",
        "Eleme",
        "Etche",
        "Gokana",
        "Ikwerre",
        "Khana",
        "Obio/Akpor",
        "Ogba/Egbema/Ndoni",
        "Ogu/Bolo",
        "Okrika",
        "Omumma",
        "Opobo/Nkoro",
        "Oyigbo",
        "Port-Harcourt",
        "Tai"
    ],
    "Sokoto": [
        "Binji",
        "Bodinga",
        "Dange-shnsi",
        "Gada",
        "Goronyo",
        "Gudu",
        "Gawabawa",
        "Illela",
        "Isa",
        "Kware",
        "kebbe",
        "Rabah",
        "Sabon birni",
        "Shagari",
        "Silame",
        "Sokoto North",
        "Sokoto South",
        "Tambuwal",
        "Tqngaza",
        "Tureta",
        "Wamako",
        "Wurno",
        "Yabo"
    ],
    "Taraba": [
        "Ardo-kola",
        "Bali",
        "Donga",
        "Gashaka",
        "Cassol",
        "Ibi",
        "Jalingo",
        "Karin-Lamido",
        "Kurmi",
        "Lau",
        "Sardauna",
        "Takum",
        "Ussa",
        "Wukari",
        "Yorro",
        "Zing"
    ],
    "Yobe": [
        "Bade",
        "Bursari",
        "Damaturu",
        "Fika",
        "Fune",
        "Geidam",
        "Gujba",
        "Gulani",
        "Jakusko",
        "Karasuwa",
        "Karawa",
        "Machina",
        "Nangere",
        "Nguru Potiskum",
        "Tarmua",
        "Yunusari",
        "Yusufari"
    ],
    "Zamfara": [
        "Anka",
        "Bakura",
        "Birnin Magaji",
        "Bukkuyum",
        "Bungudu",
        "Gummi",
        "Gusau",
        "Kaura",
        "Namoda",
        "Maradun",
        "Maru",
        "Shinkafi",
        "Talata Mafara",
        "Tsafe",
        "Zurmi"
    ]
      };

      const stateSelect = document.getElementById('hybrid_state');
      const lgaSelect = document.getElementById('hybrid_lga');

      // Populate states
      Object.keys(stateAndLGAs).forEach(state => {
        const option = document.createElement('option');
        option.value = state;
        option.textContent = state;
        stateSelect.appendChild(option);
      });

      // Populate LGAs when state is selected
      stateSelect.addEventListener('change', function () {
        const selectedState = this.value;
        lgaSelect.innerHTML = '<option value="">-- Select LGA --</option>';

        if (stateAndLGAs[selectedState]) {
          stateAndLGAs[selectedState].forEach(lga => {
            const option = document.createElement('option');
            option.value = lga;
            option.textContent = lga;
            lgaSelect.appendChild(option);
          });
        }
      });
    });

document.getElementById('addTicketBtn').addEventListener('click', function () {
  const wrapper = document.getElementById('ticketWrapper');
  const ticketHTML = `
    <div class="ticket-group mb-4">
      <label class="form-label">Ticket Name</label>
      <input type="text" class="form-control mb-2" name="ticket_name[]" placeholder="e.g. General Admission">

      <label class="form-label">Benefits</label>
      <textarea class="form-control editor mb-2" name="ticket_benefits[]" placeholder="e.g. Certificate, Lunch"></textarea>

      <label class="form-label">Price</label>
      <input type="number" class="form-control mb-2" name="ticket_price[]" min="0" step="0.01" placeholder="e.g. 5000">

      <label class="form-label">Number of Seats Available</label>
      <input type="number" class="form-control" name="ticket_seats[]" min="1" placeholder="e.g. 100">
    </div>
  `;
  wrapper.insertAdjacentHTML('beforeend', ticketHTML);
  
  // Re-init TinyMCE for new textarea
  tinymce.remove('.editor');
  tinymce.init({
    selector: '.editor',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
});



function addVideoModule() {
  const container = document.getElementById('videoModules');
  const firstModule = container.querySelector('.video-module');
  const newModule = firstModule.cloneNode(true); // deep clone

  const moduleCount = container.querySelectorAll('.video-module').length + 1;
  newModule.querySelector('.module-number').textContent = moduleCount;

  // Reset fields
  newModule.querySelectorAll('input, textarea').forEach(el => {
    if (el.type === 'checkbox' || el.type === 'radio') {
      el.checked = false;
    } else {
      el.value = '';
    }
  });

  // Update checkbox name attributes
  newModule.querySelectorAll('input[type="checkbox"]').forEach(el => {
    if (el.name.startsWith('video_quality')) {
      el.name = `video_quality[${moduleCount - 1}][]`;
    }
    if (el.name.startsWith('video_subtitles')) {
      el.name = `video_subtitles[${moduleCount - 1}]`;
    }
  });

  // Give each textarea.editor a unique ID
  newModule.querySelectorAll('.editor').forEach((textarea, index) => {
    textarea.id = `video_editor_${moduleCount}_${index}`;
  });

  container.appendChild(newModule);
  reinitTinyMCE();
}

function addTextModule() {
  const container = document.getElementById('textModules');
  const firstModule = container.querySelector('.text-module');
  const newModule = firstModule.cloneNode(true); // deep clone

  const moduleCount = container.querySelectorAll('.text-module').length + 1;
  newModule.querySelector('.module-number').textContent = moduleCount;

  // Reset fields
  newModule.querySelectorAll('input, textarea').forEach(el => {
    if (el.type === 'checkbox' || el.type === 'radio') {
      el.checked = false;
    } else {
      el.value = '';
    }
  });

  // Give each textarea.editor a unique ID
  newModule.querySelectorAll('.editor').forEach((textarea, index) => {
    textarea.id = `text_editor_${moduleCount}_${index}`;
  });

  container.appendChild(newModule);
  reinitTinyMCE();
}

function reinitTinyMCE() {
  // Destroy all editors before reinitializing
  tinymce.remove('.editor');

  tinymce.init({
    selector: '.editor',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
}

function previewProfilePicture(event) {
  var reader = new FileReader();
  reader.onload = function(){
      var output = document.getElementById('profilePicturePreview');
      output.src = reader.result;
  };
  reader.readAsDataURL(event.target.files[0]);
}



function togglePricingFields() {
  var pricing = document.getElementById('pricingSelect').value;
  document.getElementById('donationFields').style.display = (pricing === 'donation') ? 'block' : 'none';
  document.getElementById('freeFields').style.display = (pricing === 'free') ? 'block' : 'none';
  document.getElementById('paidFields').style.display = (pricing === 'paid') ? 'block' : 'none';
}

function displayInstructorInfo() {
  var select = document.getElementById('instructorSelect');
  var selected = select.options[select.selectedIndex];
  var infoDiv = document.getElementById('instructorInfo');
  var addFields = document.getElementById('addInstructorFields');
  if (select.value === "add_new") {
    infoDiv.style.display = "none";
    addFields.style.display = "block";
  } else if (select.value !== "") {
    document.getElementById('instructorPhoto').src = selected.getAttribute('data-photo');
    document.getElementById('instructorName').textContent = selected.getAttribute('data-name');
    infoDiv.style.display = "block";
    addFields.style.display = "none";
  } else {
    infoDiv.style.display = "none";
    addFields.style.display = "none";
  }
}
function toggleDeliveryFields() {
  const format = document.getElementById('deliveryFormat').value;

  // List of all section IDs
  const sections = [
    'physicalFields',
    'onlineFields',
    'hybridFields',
    'videoFields',
    'textFields'
  ];

  // Hide all first
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (el) el.style.display = 'none';
  });

  // Show only the selected one
  if (format === 'physical') {
    document.getElementById('physicalFields').style.display = 'block';
  } 
  else if (format === 'online') {
    document.getElementById('onlineFields').style.display = 'block';
  } 
  else if (format === 'hybrid') {
    document.getElementById('hybridFields').style.display = 'block';
    toggleHybridLocationFields(); // Still call this if needed
  } 
  else if (format === 'video') {
    document.getElementById('videoFields').style.display = 'block';
  } 
  else if (format === 'text') {
    document.getElementById('textFields').style.display = 'block';
  }
}


  function toggleHybridLocationFields() {
    const type = document.getElementById('hybridLocationType').value;
    const nigeriaFields = document.getElementById('nigeriaHybridFields');
    const foreignFields = document.getElementById('foreignHybridFields');

    // Hide both
    nigeriaFields.style.display = 'none';
    foreignFields.style.display = 'none';

    // Clear inputs in both sections first
    document.querySelectorAll('#nigeriaHybridFields input').forEach(input => input.value = '');
    document.querySelectorAll('#foreignHybridFields input').forEach(input => input.value = '');

    // Then show and use only the selected section
    if (type === 'nigeria') {
      nigeriaFields.style.display = 'block';
    } else if (type === 'foreign') {
      foreignFields.style.display = 'block';
    }
  }

  function togglePhysicalLocationFields() {
    const type = document.getElementById('physicalLocationType').value;
    const nigeriaFields = document.getElementById('nigeriaPhysicalFields');
    const foreignFields = document.getElementById('foreignPhysicalFields');

    nigeriaFields.style.display = 'none';
    foreignFields.style.display = 'none';

    // Clear both
    document.querySelectorAll('#nigeriaPhysicalFields input').forEach(input => input.value = '');
    document.querySelectorAll('#foreignPhysicalFields input').forEach(input => input.value = '');

    if (type === 'nigeria') {
      nigeriaFields.style.display = 'block';
    } else if (type === 'foreign') {
      foreignFields.style.display = 'block';
    }
  }

function addDateTimeRow() {
  const container = document.getElementById('dateTimeRepeater');
  const row = document.createElement('div');
  row.className = 'row mb-2 dateTimeRow';
  row.innerHTML = `
    <div class="col">
      <input type="date" class="form-control" name="event_dates[]" required>
    </div>
    <div class="col">
      <input type="time" class="form-control" name="event_start_times[]" required>
    </div>
    <div class="col">
      <input type="time" class="form-control" name="event_end_times[]" required>
    </div>
    <div class="col-auto">
      <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.dateTimeRow').remove()">-</button>
    </div>
  `;
  container.appendChild(row);
}

function toggleQuizOption(option) {
  document.getElementById('quizText').style.display = 'none';
  document.getElementById('quizUpload').style.display = 'none';
  document.getElementById('quizFormButton').style.display = 'none';

  if (option === 'text') {
    document.getElementById('quizText').style.display = 'block';
  } else if (option === 'upload') {
    document.getElementById('quizUpload').style.display = 'block';
  } else if (option === 'form') {
    document.getElementById('quizFormButton').style.display = 'block';
  }
}


function toggleReplies(commentId) {
  var replies = document.getElementById('replies-' + commentId);
  if (replies.style.display === 'none') {
    replies.style.display = 'block';
  } else {
    replies.style.display = 'none';
  }
}
function showReplyForm(commentId) {
  var form = document.getElementById('reply-form-' + commentId);
  if (form.style.display === 'none') {
    form.style.display = 'block';
  } else {
    form.style.display = 'none';
  }
}

function updateStatus() {
  const status = document.getElementById('statusAction').value;
  if (!status) return;
  
  if (confirm('Are you sure you want to update the status?')) {
      const form = document.createElement('form');
      form.method = 'POST';
      
      const ticketInput = document.createElement('input');
      ticketInput.type = 'hidden';
      ticketInput.name = 'ticket_id';
      ticketInput.value = document.getElementById('ticket_id').value;

      const actionInput = document.createElement('input');
      actionInput.type = 'hidden';
      actionInput.name = 'update-dispute';
      actionInput.value = 'dispute_update';
      
      const statusInput = document.createElement('input');
      statusInput.type = 'hidden';
      statusInput.name = 'status';
      statusInput.value = status;
      
      form.appendChild(ticketInput);
      form.appendChild(actionInput);
      form.appendChild(statusInput);
      document.body.appendChild(form);
      form.submit();
  }
}


function updateWallet() {
  const walletForm = document.getElementById('walletForm');
  if (confirm('Are you sure you want to modify the wallet?')) {
      walletForm.method = 'POST';
      walletForm.submit();
  }
}


function openQuizModal() {
  document.getElementById('quizModal').style.display = 'block';
}

function closeQuizModal() {
  document.getElementById('quizModal').style.display = 'none';
}

let questionCounter = 1;

function addQuizQuestionModal() {
  const originalBlock = document.querySelector('.question-block');

  // Clone original block
  const clone = originalBlock.cloneNode(true);
  questionCounter++;

  // Remove any existing TinyMCE editor DOM wrappers from the clone
  const oldEditorWrapper = clone.querySelector('.tox-tinymce');
  if (oldEditorWrapper) {
    // Replace the entire TinyMCE wrapper with a new textarea
    const newTextarea = document.createElement('textarea');
    newTextarea.name = 'questions[]';
    newTextarea.placeholder = 'Question';
    newTextarea.className = 'form-control mb-2 editor';
    newTextarea.id = `question_editor_${questionCounter}`;

    oldEditorWrapper.parentNode.replaceChild(newTextarea, oldEditorWrapper);
  } else {
    // Fallback: if somehow there's no wrapper, still update the ID
    const textarea = clone.querySelector('textarea[name="questions[]"]');
    if (textarea) {
      textarea.id = `question_editor_${questionCounter}`;
      textarea.value = '';
    }
  }

  // Reset inputs
  clone.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
  clone.querySelector('select[name="correct_answer[]"]').selectedIndex = 0;

  // Remove existing remove button
  const oldRemoveBtn = clone.querySelector('.remove-question');
  if (oldRemoveBtn) oldRemoveBtn.remove();

  // Add new remove button
  const removeBtn = document.createElement('button');
  removeBtn.type = 'button';
  removeBtn.className = 'btn btn-danger remove-question';
  removeBtn.innerHTML = '🗑️ Remove';
  const hr = clone.querySelector('hr');
  clone.insertBefore(removeBtn, hr);

  // Append clone to DOM
  document.getElementById('quizBuilderModal').appendChild(clone);

  // Init TinyMCE on new textarea
  tinymce.init({
    selector: `#question_editor_${questionCounter}`,
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
}

// 🗑️ Remove cloned question blocks
document.addEventListener('click', function(e) {
  if (e.target.classList.contains('remove-question')) {
    const block = e.target.closest('.question-block');
    const editor = block.querySelector('textarea.editor');
    if (editor && tinymce.get(editor.id)) {
      tinymce.get(editor.id).remove();
    }
    block.remove();
  }
});



