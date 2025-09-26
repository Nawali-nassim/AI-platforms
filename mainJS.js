document.addEventListener('DOMContentLoaded', function() {
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
    const menuToggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('nav ul');
    if (menuToggle && menu) {
        menuToggle.addEventListener('click', () => {
            menu.classList.toggle('active');
        });
    }
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
});