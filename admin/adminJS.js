document.addEventListener('DOMContentLoaded', function() {

//delete platform modal functionality-----------------------------------------------------------------------------------------------
  const page = document.getElementById('pageContent');  
  const deleteModal = document.getElementById('deletePlatformModal');
  const dpNameTitle = document.getElementById('deletePlatformNameTitle');
  const dpMsg = document.getElementById('dpMsg'); // verification message for delete
  let currentDeleteId = null; // store the ID for deletion

  function openModalD(id, name) {
    //closeAllModals();
    dpNameTitle.textContent = name;
    currentDeleteId = id; // store the ID
    page.setAttribute('inert','');
    if(dpMsg) dpMsg.style.display = 'none';
    deleteModal.setAttribute("aria-hidden", "false");
    deleteModal.style.display = 'flex';
  }

  function closeModalD() {
    deleteModal.style.display = 'none';
    deleteModal.setAttribute('aria-hidden', 'true');
    if(dpMsg) dpMsg.style.display = 'none';
    page.removeAttribute('inert');
  }

  function closeAllModals() {
    [modal, deleteModal].forEach(m => {
      if (!m) return;
      m.style.display = 'none';
      m.setAttribute('aria-hidden', 'true');
    });
    document.activeElement?.blur();
    page.removeAttribute('inert');
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
            body: 'id=' + platformId + '&type=' + this.dataset.type //the content of the POST request
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

// edit/add platform modal functionality-----------------------------------------------------------------------------------------------
    const modal = document.getElementById('editPlatformModal');
    const pNameTitle = document.getElementById('editPlatformTitle');
    const pId = document.getElementById('platformId');
    const pName = document.getElementById('platformName');
    const pText = document.getElementById('platformDescription');
    const pLink = document.getElementById('platformLink');
    const pNumberC = document.getElementById('platformNumberC');
    const pIcon = document.getElementById('platformIcon');
    const pIconName = document.getElementById('fileName');
    const epMsg = document.getElementById('epMsg');
    const editForm = document.getElementById('editPlatformForm');
    const closeBtn = modal.querySelector('.modal-close');
    const cancelBtn = modal.querySelector('.btn-cancel');
    const addBtn = document.getElementById('addPlatformBtn');

    let mode='edit';

    function openEdit(id, name, desc, link, numberC, icon) {
      closeAllModals();
      page.setAttribute('inert','');
      mode='edit';
      pNameTitle.textContent = "Edit " + name;
      pName.value = name;
      pId.value = id;
      pText.value = desc;
      pLink.value = link;
      pNumberC.value = numberC;
      pIconName.textContent = icon ? 'file name : ' + icon : 'file name : there is no icon';
      console.log('Opening edit modal for ID:', id, 'Name:', name);
      
      if(epMsg) epMsg.style.display = 'none';
      modal.setAttribute("aria-hidden", "false");
      modal.style.display = 'flex';
      setTimeout(() => pName.focus(), 0);
    }
    
    function openAdd() {
        closeAllModals();
        page.setAttribute('inert','');
        mode='add';
        pNameTitle.textContent = 'Add new platform';
        pName.value = '';
        pId.value = '';
        pText.value = '';
        pLink.value = '';
        pIcon.value = '';
        pIconName.textContent = 'Choose icon';
        console.log('Opening add modal');

        if(epMsg) epMsg.style.display = 'none';
        modal.setAttribute("aria-hidden", "false");
        modal.style.display = 'flex';
        setTimeout(() => pName.focus(), 0);
      }

    function closeModal() {
      modal.style.display = 'none';
      modal.setAttribute('aria-hidden', 'true');
      if(epMsg) epMsg.style.display = 'none';
      page.removeAttribute('inert');
    }
    
    if(closeBtn) closeBtn.addEventListener('click', closeModal);
    if(cancelBtn) cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e){ if (e.target === modal) closeModal(); });

    document.querySelectorAll('.editPlatform').forEach(btn => {
      btn.addEventListener('click', function () {
        openEdit(this.dataset.id, this.dataset.name, this.dataset.description, this.dataset.link, this.dataset.idcategory, this.dataset.icon);
      });
    });

    // Add platform functionality
    if(addBtn) {
      addBtn.addEventListener('click', openAdd);
    } else {
      console.error('ERROR: addPlatformBtn not found');
    }

    // One submit handler for both add and edit
    if(editForm) {
      editForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData();
        formData.append('action', mode); // 'edit' or 'add'
        if(mode === 'edit') {
          formData.append('platform_id', pId.value);
        }
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
          // Optionally close modal on success
          // setTimeout(() => closeModal(), 1500);
        })
        .catch(err => {
          if(epMsg) {
            epMsg.style.display = 'block';
            epMsg.textContent = 'Error: ' + err;
          }
        });
      });
    } else {
      console.error('ERROR: editPlatformForm not found');
    }
    //delete category modal functionality-----------------------------------------------------------------------------------------------

});