document.addEventListener('DOMContentLoaded', function() {

//delete platform modal functionality-----------------------------------------------------------------------------------------------
  const deleteModal = document.getElementById('deletePlatformModal');
  const dpNameTitle = document.getElementById('deletePlatformNameTitle');
  const dpMsg = document.getElementById('dpMsg'); // verification message for delete
  let currentDeleteId = null; // store the ID for deletion

  function openModalD(id, name) {
    dpNameTitle.textContent = name;
    currentDeleteId = id; // store the ID
    if(dpMsg) dpMsg.style.display = 'none';
    deleteModal.style.display = 'flex';
    deleteModal.setAttribute('aria-hidden','false');
  }
  function closeModalD() {
    deleteModal.style.display = 'none';
    deleteModal.setAttribute('aria-hidden','true');
    if(dpMsg) dpMsg.style.display = 'none';
  }

 document.querySelectorAll('.deletePlatform').forEach(icon => {
    icon.addEventListener('click', function() {
      openModalD(this.dataset.id, this.dataset.name);
    });
});
document.querySelectorAll('.btn-delete').forEach(debtn => {
  debtn.addEventListener('click', function() {
        let platformId = currentDeleteId; // use the stored ID
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
            if(dpMsg) {
              dpMsg.textContent = data;
              dpMsg.style.display = 'block';
            } else {
              alert(data); // fallback if element doesn't exist
            }
            // close modal after a short delay on success
            setTimeout(() => closeModalD(), 1500);
        });
        console.log('Delete platform with ID:', platformId);
    });
  });

  deleteModal.querySelector('.Dmodal-close').addEventListener('click', closeModalD);
  deleteModal.querySelector('.Dbtn-cancel').addEventListener('click', closeModalD);

//edit platform modal functionality-----------------------------------------------------------------------------------------------
  const modal = document.getElementById('editPlatformModal');
  
  if(!modal) {
    console.error('ERROR: editPlatformModal element not found in HTML!');
  } else {
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
      
      if(epMsg) epMsg.style.display = 'none';
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

    const closeBtn = modal.querySelector('.modal-close');
    const cancelBtn = modal.querySelector('.btn-cancel');
    
    if(closeBtn) closeBtn.addEventListener('click', closeModal);
    if(cancelBtn) cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });

    // submit via fetch to editPlatform.php
    const editForm = document.getElementById('editPlatformForm');
    if(editForm) {
      editForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData();
        formData.append('platform_id', pId.value);
        formData.append('platform_name', pName.value);
        formData.append('platform_description', pText.value);
        formData.append('platform_link', pLink.value);
        formData.append('platform_numberC', pNumberC.value);
        if(pIcon.files.length > 0){
            formData.append('platform_icon', pIcon.files[0]);
        }
        fetch('editPlatform.php', {
          method: 'POST',
          body: formData
        })
        .then(r => r.text())
        .then(txt => {
          if(epMsg) {
            epMsg.style.display = 'block';
            epMsg.textContent = txt;
          }
        })
      });
    }
  }

// Add platform modal functionality-------------------------------------------------------------------------------------------------
const addBtn = document.getElementById('addPlatformBtn');
if(addBtn && modal) {
  addBtn.addEventListener('click', function() {
    // Clear form fields for new entry
    document.getElementById('platformId').value = '';
    document.getElementById('platformName').value = '';
    document.getElementById('platformDescription').value = '';
    document.getElementById('platformLink').value = '';
    document.getElementById('platformNumberC').value = '';
    document.getElementById('platformIcon').value = '';
    
    // Update modal title
    const titleEl = document.getElementById('editPlatformTitle');
    const nameEl = document.getElementById('platformNameTitle');
    if(titleEl) titleEl.textContent = 'Add New Platform';
    if(nameEl) nameEl.textContent = 'New Platform';
    
    // Show modal
    modal.style.display = 'flex';
    modal.setAttribute('aria-hidden', 'false');
  });
} else {
  if(!addBtn) console.error('ERROR: addPlatformBtn not found');
  if(!modal) console.error('ERROR: modal not found');
}

});
