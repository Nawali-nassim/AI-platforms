document.addEventListener('DOMContentLoaded', function() {

    // Username validation------------------------------------------------------------------------------------------------------
    document.querySelectorAll('.validate-username').forEach(function(input) {
        input.addEventListener('input', function() {
            var pattern = /^[A-Za-z0-9_@#&-]+$/;
            if (!pattern.test(this.value)) {
                this.setCustomValidity('Username can only contain English letters, numbers, and _ @ # & - characters.');
            } else {
                this.setCustomValidity('');
            }
        });
    });


    // Mobile menu toggle--------------------------------------------------------------------------------------------------------------
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('nav ul');
    if (menuToggle && menu) {
        menuToggle.addEventListener('click', () => {
            menu.classList.toggle('active');
        });
    }


    // Category filtering-------------------------------------------------------------------------------------------------
  const catCards = document.querySelectorAll('.categoryCard');
  const platforms = document.querySelectorAll('.platformCard');
  const titles = document.querySelectorAll('.title');
  const defaultTitle = document.getElementById('defaultTitle');

  const emptyMsg = document.getElementById('empty-msg');

  /*if (catCards.length > 0) {
    catCards[0].classList.add('active');
    showCategory(catCards[0].dataset.cat);
  }*/

  catCards.forEach(card => {
    card.addEventListener('click', () => {
      catCards.forEach(c => c.classList.remove('active'));
      card.classList.add('active');
      defaultTitle.style.display = 'none';
      showCategory(card.dataset.cat);
    });

    // support keyboard navigation
    card.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        card.click();
      }
    });
  });

  function showCategory(catid) {
    let anyVisible = false;
    titles.forEach(t => {
      if ((t.dataset.cat) === catid) {
        t.style.display = 'block';
      } else {
        t.style.display = 'none';
      }});
      
    platforms.forEach(p => {
      if (p.dataset.cat === catid) {
        p.style.display = ''; 
        anyVisible = true;
      } else {
        p.style.display = 'none';
      }
    });
    emptyMsg.style.display = anyVisible ? 'none' : '';
  }

// Search functionality---------------------------------------------------------------------------------------------------------
  const sInput= document.getElementById('searchInput');
        sInput.addEventListener('keyup',function(){
            let value =sInput.value.toLowerCase();
            const Platforms= document.querySelectorAll('.platformCard');
            Platforms.forEach(Platform =>{
                let text = Platform.textContent.toLowerCase();
                if (text.includes(value)){
                    Platform.style.display = '';
                } else {
                    Platform.style.display = 'none';
                }
            });
            
        });

// Feedback modal functionality-----------------------------------------------------------------------------------------------
        const modal = document.getElementById('feedbackModal');
  const fbName = document.getElementById('fbPlatformName');
  const fbId = document.getElementById('fbPlatformId');
  const fbText = document.getElementById('fbText');
  const fbMsg = document.getElementById('fbMsg');

  function openModal(id, name) {
    fbName.textContent = name;
    fbId.value = id;
    fbText.value = '';
    fbMsg.style.display = 'none';
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden','false');
    fbText.focus();
  }
  function closeModal() {
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden','true');
  }

  document.querySelectorAll('.feedback-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      openModal(this.dataset.id, this.dataset.name);
    });
  });

  modal.querySelector('.modal-close').addEventListener('click', closeModal);
  modal.querySelector('.btn-cancel').addEventListener('click', closeModal);
  modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });// close when clicking outside modal box

  // submit via fetch to feedback.php
  document.getElementById('feedbackForm').addEventListener('submit', function (e) {
    e.preventDefault(); /*Normally, submitting a form reloads the page.
        This line stops that, so you can handle the submission using JavaScript (via AJAX) instead.*/
    const formData = new URLSearchParams(new FormData(this));
      /*new FormData(this):: collects all the form’s inputs (from the current form element, this).
      new URLSearchParams(...):: converts it into a URL-encoded string (like name=John&message=Hi), which is easy to send in an HTTP request.*/
    fetch('feedback.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: formData.toString()
    })
    .then(r => r.text())
    .then(txt => {
      fbMsg.style.display = 'block';
      fbMsg.textContent = txt;
      // optionally close the model after success
      if (txt.toLowerCase().includes('thank') || txt.toLowerCase().includes('saved')) {
        setTimeout(closeModal, 1000);
      }
    })
    .catch(err => {
      fbMsg.style.display = 'block';
      fbMsg.textContent = 'Error sending feedback';
    });
  });

// Favorite icon toggle functionality--------------------------------------------------------------------------------------
  document.querySelectorAll('.favorite-icon').forEach(icon => {
    icon.addEventListener('click', function() {
        let platformId = this.getAttribute('data-id');
        let el = this;//to refer to the clicked icon

        // toggle favorite status 
        let action = el.classList.contains('active') ? 'remove' : 'add';
        //using ajax to send the request to favorite.php:
        fetch('favorite.php', {//options
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
                //to send data in URL-encoded format eg: id=1&action=add ,can be json too
            },
            body: 'id=' + platformId + '&action=' + action //the content of the POST request
        })
        .then(response => response.text())//get the response as text from the server
        .then(data => {
            console.log(data);
            alert(data);//show the response in an alert box
            if (action === 'add') {//change the icon shape
                el.classList.add('active', 'fas');
                el.classList.remove('far');
            } else {
                el.classList.remove('active', 'fas');
                el.classList.add('far');
            }
        });
    });
});
});