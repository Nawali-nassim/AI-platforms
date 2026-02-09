document.addEventListener('DOMContentLoaded', function() {

 document.querySelectorAll('.deletePlatform').forEach(icon => {
    icon.addEventListener('click', function() {
        let platformId = this.dataset.id;
        //using ajax to send the request to deletePlatform.php:
        fetch('deletePlatform.php', {//options
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
                //to send data in URL-encoded format eg: id=1&action=add ,can be json too
            },
            body: 'id=' + platformId  //the content of the POST request
        })
        .then(response => response.text())//get the response as text from the server
        .then(data => {
            console.log(data);
            alert(data);//show the response in an alert box
        });
        console.log('Delete platform with ID:', platformId);
    });
});
//edit platform modal functionality-----------------------------------------------------------------------------------------------
  const modal = document.getElementById('editPlatrormModal');
  const pName = document.getElementById('platformName');
  const pNameTitle = document.getElementById('platformNameTitle');
  const pId = document.getElementById('platformId');
  const pText = document.getElementById('platformDescription');
  const pLink = document.getElementById('platformLink');
  const pNumberC = document.getElementById('platformNumberC');
  const pIcon = document.getElementById('platformIcon');
  const epMsg = document.getElementById('epMsg');

  function openModal(id, name, desc, link, numberC, icon) {
    pNameTitle.textContent = name;
    pName.textContent = name;
    pId.value = id;
    pText.value = desc;
    pLink.value = link;
    pNumberC.value = numberC;
    pIcon.value = icon;
    epMsg.style.display = 'none';
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden','false');
    pName.focus();
  }
  function closeModal() {
    modal.style.display = 'none';
    modal.setAttribute('aria-hidden','true');
  }

  document.querySelectorAll('.editPlatform').forEach(btn => {
    btn.addEventListener('click', function () {
      openModal(this.dataset.id, this.dataset.name, this.dataset.description, this.dataset.link, this.dataset.idcategory, this.dataset.icon);
    });
  });

  modal.querySelector('.modal-close').addEventListener('click', closeModal);
  modal.querySelector('.btn-cancel').addEventListener('click', closeModal);
  modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });// close when clicking outside modal box

  // submit via fetch to feedback.php
  document.getElementById('editPlatformForm').addEventListener('submit', function (e) {
    e.preventDefault(); /*Normally, submitting a form reloads the page.
        This line stops that, so you can handle the submission using JavaScript (via AJAX) instead.*/
    /*const formData = new URLSearchParams(new FormData(this));
      new FormData(this):: collects all the form’s inputs (from the current form element, this).
      new URLSearchParams(...):: converts it into a URL-encoded string (like name=John&message=Hi), which is easy to send in an HTTP request.*/
    const formData = new FormData();
    formData.append('platform_id', pId.value);
    formData.append('platform_name', pName.value);
    formData.append('platform_description', pText.value);
    formData.append('platform_link', pLink.value);
    formData.append('platform_numberC', pNumberC.value);
    if(pIcon.files.length > 0){ // check if a new file is selected
        formData.append('platform_icon', pIcon.files[0]); // for file input, use files[0] to get the selected file
    }
    fetch('editPlatform.php', {
      method: 'POST',
      //we don't set Content-Type header when sending FormData, browser will set it to multipart/form-data with the correct boundary
      body: formData
    })
    .then(r => r.text())
    .then(txt => {
      epMsg.style.display = 'block';
      epMsg.textContent = txt;
      // optionally close the model after success
    })
    /*.catch(err => {
      epMsg.style.display = 'block';
      epMsg.textContent = 'Error sending feedback';
    });*/
  });

});