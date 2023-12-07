function addEventListeners() {

    let changePic = document.querySelector('#fileInput');
    if (changePic != null)
    changePic.addEventListener('change', handleFileSelect);

    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {
          this.parentNode.parentNode.classList.toggle('selected', this.checked);
      });
    });

    if (document.getElementById("CreateTaskModalButton")) {
      setupTaskForm("createtaskform", 'CreateTaskModalButton', 'ModalCreateTask', {
        'Dashboard': 'dashboard',
        'Tasks': 'tasks',
      });
    }
    if (document.getElementById("EditTaskModalButton")) {
      setupTaskForm("edittaskform", 'EditTaskModalButton', 'ModalEditTask',{
        'Details': 'details',
      });
    }

    if (document.getElementById("AddMemberModalButton")) {
      setupTaskForm("addmemberform", 'AddMemberModalButton', 'ModalAddMember',{
        'Members': 'members',
      });
    }
    
    document.getElementById("notifications-button").addEventListener("click", function(event) {
      document.getElementById("notifications-dropdown").classList.toggle("hide");
    });

    document.getElementById('leaveProject').addEventListener('click', function(event) {
      event.preventDefault();
      Swal.fire({
          title: "Are you sure?",
          text: "Once left, you will not be able to rejoin the project!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, I am sure!',          

      })
      .then((result) => {
        if (result.isConfirmed) {
          const urlPath = window.location.pathname;
          const pathParts = urlPath.split('/');
          const projectId = pathParts[pathParts.length - 1];
          console.log(projectId);
            removeFromProject(projectId);
            location.reload();
        }
      });
    });

    setupRadioButtons()
} 
  
  function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }
  
  function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();
  
    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
  }

  function getCSRF() {
    let tokenField = document.createElement('input')
    tokenField.type = "hidden"
    tokenField.name = "_token"
    tokenField.value = document.querySelector("head meta[name='csrf-token']").content;
    return tokenField;
  }  
  
  function handleFileSelect(event) {
    const fileInput = event.target;
    console.log(event);
    const file = fileInput.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const profilePicture = document.getElementById('profilePicture');
            profilePicture.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
  }

  function searchProjects(page = 1) {
    var input = document.getElementById('projectSearch');
    var filter = input.value;
    var url = '/search-projects?filter=' + encodeURIComponent(filter) + '&page=' + page;
    sendAjaxRequest('GET', url, {}, handleSearchProject);
}


function searchTasks() {
      var input = document.getElementById('taskSearch');
      var filter = input.value; 
      var project_id = document.getElementById('tasks-container').className;
      sendAjaxRequest('POST', '/search-tasks', { filter: filter, project_id : project_id}, handleSearchTask);
}

function handleSearchTask(){
  if (this.status >= 200 && this.status < 400) {
    var data = JSON.parse(this.response);
    var container = document.querySelector('#tasks-container');
    var ul = document.querySelector('.TasksList');
    if (!ul) {
        ul = document.createElement('ul');
        ul.classList.add('TasksList');
        container.appendChild(ul);
    }
    ul.innerHTML = '';

    data.forEach(task => {
        var li = document.createElement('li');
        li.classList.add('task-item');

        var div = document.createElement('div');

        var a = document.createElement('a');
        a.href = '/task/' + task.task_id;
        a.classList.add('task-link');

        var title = document.createElement('p');
        title.classList.add('TaskTitle');
        title.textContent = task.title;
        div.appendChild(title);

        var description = document.createElement('p');
        description.classList.add('task-description');
        
        description.textContent = task.description;
        div.appendChild(description);

        var deadline = document.createElement('p');
        deadline.classList.add('FinishDate');
        if(task.finish_date == null) deadline.textContent = " Deadline: Not defined ";
        else{
        deadline.textContent = "Deadline: " + task.finish_date;
        }
        div.appendChild(deadline);

        li.appendChild(div);
        a.appendChild(li);
        ul.appendChild(a);
    });
}
  else {
      console.error('Error:', this.status, this.statusText);
  }
}


function handleSearchProject() {

    console.log(this.response)
    if (this.status >= 200 && this.status < 400) {
      var data = JSON.parse(this.response);
      var container = document.querySelector('#projects-container');
      var ul = container.querySelector('.projects-list');
      if (!ul) {
          ul = document.createElement('ul');
          ul.classList.add('projects-list');
          container.appendChild(ul);
      }
      ul.innerHTML = ''; 
      data.projects.forEach(project => {
          var li = document.createElement('li');
          li.classList.add('project-item');

          var div = document.createElement('div');
          div.classList.add('project-content');
          div.classList.add(project.project_id);

          var a = document.createElement('a');
          a.href = '/project/' + project.project_id;
          a.classList.add('project-link');

          var title = document.createElement('h2');
          title.classList.add('projects-title');
          title.textContent = project.title;
          div.appendChild(title);

          var coordinator = document.createElement('p');
          coordinator.classList.add('project-coordinator');
          coordinator.classList.add('project-info');
          
          var id = project.created_by;

          var deadline = document.createElement('p');
          deadline.classList.add('project-deadline');
          deadline.classList.add('project-info');
          if(project.finish_date == null) deadline.textContent = " Not defined ";
          else{ deadline.textContent = project.finish_date;}
          div.appendChild(deadline);

          var otherdiv = document.createElement('div');
          otherdiv.classList.add('project-details');
          var description = document.createElement('p');
          description.classList.add('project-info');
          description.textContent = project.description;
          otherdiv.appendChild(description);
        

          li.appendChild(div);
          li.appendChild(otherdiv);
          a.appendChild(li);
          ul.appendChild(a);

          

          sendAjaxRequest('POST', '/user-name' ,{id : id}, function() {
            if (this.status >= 200 && this.status < 400) {
                var data = JSON.parse(this.response);
                var userName = data.name;
                var coordinator = document.createElement('p');
                coordinator.classList.add('project-info');
                coordinator.classList.add('project-coordinator');
                coordinator.textContent += userName;
                var element = document.querySelector('[class="' + project.project_id + '"]');
                div.appendChild(coordinator);
            }
        });

        document.querySelector('.pagination-container').innerHTML = '';
        if (data.currentPage != 1) {
          const previousPageUrl = document.createElement('button');
          previousPageUrl.onclick = function() {
            searchProjects(data.currentPage - 1);
        };
          previousPageUrl.textContent = 'Previous';
          previousPageUrl.classList.add('btn');
          document.querySelector('.pagination-container').appendChild(previousPageUrl);
        }
        const currentPage = document.createElement('span');
        currentPage.textContent = 'Page ' + data.currentPage + ' of ' + data.lastPage;
        document.querySelector('.pagination-container').appendChild(currentPage);
        if (data.hasMorePages) {
          const nextPageUrl = document.createElement('button');
          nextPageUrl.onclick = function() {
            searchProjects(data.currentPage + 1);
          };
          nextPageUrl.textContent = 'Next';
          nextPageUrl.classList.add('btn');
          document.querySelector('.pagination-container').appendChild(nextPageUrl);
        }

      });
  } else {
      console.error('Error:', this.status, this.statusText);
  }
}

function setupRadioButtons() {
  const radios = document.querySelectorAll('#projectForm input[type="radio"]');

  radios.forEach(function(radio) {
    radio.addEventListener('change', function() {
      const id = this.value;
      document.querySelector('label.selected').classList.toggle('selected', false);
      this.parentNode.classList.toggle('selected', this.checked);       
      const toHide = document.querySelector('#MainContent .selected')
      if (toHide) {
        toHide.classList.toggle('selected', false);
      }

      const toDisplay = document.querySelector('#MainContent div#' + id);
      if (toDisplay) {
        toDisplay.classList.toggle('selected', this.checked);
      }
    });
  });
}

function handleTaskFormSubmit(modalId, viewsToUpdate, event) {
  event.preventDefault();

  if (!isTaskFormValid()) {
    return;
  }

  let url = this.getAttribute('action');
  let formData = new FormData(this);

  fetch(url, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest', // This is to let Laravel know this is an AJAX request
    },
  })
  .then(response => response.json())
  .then(data => {
    let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
    modal.hide();
    
    for (let sectionId in viewsToUpdate) {
      document.getElementById(sectionId).innerHTML = data[viewsToUpdate[sectionId]];
    }
    addEventListeners();
  })
  .catch(error => console.error('Error:', error));
}


function handleAddMember(modalId, event) {
  console.log("handleAddMember");
  event.preventDefault();
  let url = this.getAttribute('action');
  let formData = new FormData(this);
  let csrf = document.querySelector("input[name='_token']").content;
  

  console.log("URL:", url);
for (var pair of formData.entries()) {
    console.log(pair[0]+ ', ' + pair[1]); 
}
  fetch(url, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest', // This is to let Laravel know this is an AJAX request
      'X-CSRF-TOKEN': csrf,
    },
  })
  .then(response => response.json())
  .then(data => {
    let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
    modal.hide();
  })
}

function isTaskFormValid() {
  let title = document.getElementById("title").value;
  let description = document.getElementById("description").value;
  let finishDate = document.getElementById("finish_date").value;

  document.getElementById('titleError').innerHTML = '';
  document.getElementById('descriptionError').innerHTML = '';
  document.getElementById('finish_dateError').innerHTML = '';

  if (title.length < 15 || title.length > 50) {
      document.getElementById('title').classList.add('validation-err');
      document.getElementById('titleError').innerHTML = 'Title must be between 15 and 50 characters long';
      return false;
  }

  if (description.length < 100 || description.length > 300) {
      document.getElementById('descriptionError').innerHTML = 'Description must be between 100 and 300 characters long';
      return false;
  }

  if (finishDate) {
    if(new Date(finishDate) <= new Date()){
      document.getElementById('finish_dateError').innerHTML = 'Finish date must be after today';
      return false;
    }
  }

  return true;
}

function setupTaskForm(formId, buttonId, modalId, viewsToUpdate) {
  let form = document.getElementById(formId);
  switch (formId) {
    case 'addmemberform':
      document.getElementById(formId).addEventListener("submit", handleAddMember.bind(form, modalId));
      break;
  }

  document.getElementById(buttonId).addEventListener('click', function () {
    let modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
  });
}

function dismiss_notification(notificationId) {
  console.log(notificationId);
  sendAjaxRequest('POST', '/dismiss-notification', {notificationId: notificationId}, function() {
    if (this.status >= 200 && this.status < 400) {
      let notificationElement = document.getElementById('n'+notificationId);
      notificationElement.style.transition = "transform 0.5s ease-out";
      notificationElement.style.transform = "translateX(100%)";
      setTimeout(function() {
          notificationElement.style.display = "none";
      }, 500);
    }
  });
}

function accept_invite(project_id, notification_id, member_id) {
  sendAjaxRequest('POST', '/addMember', {project_id: project_id, member_id: member_id}, function() {
    if (this.status >= 200 && this.status < 400) {
      dismiss_notification(notification_id);
    }
  });

}

function removeFromProject(projectId){
  sendAjaxRequest('DELETE', '/leaveProject/'+projectId, {}, function() {
    if (this.status >= 200 && this.status < 400) {
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  addEventListeners();
});


// pusher notifications

const pusherAppKey = "fb8ef8f4fa10afc9c38c";
const pusherCluster = "eu";

console.log(pusherAppKey);
console.log(pusherCluster);

const pusher = new Pusher(pusherAppKey, {
  cluster: pusherCluster,
  encrypted: true
});

const channel = pusher.subscribe('project-invite');
channel.bind('notification-invite', function(data) {
  console.log(data);
  if(data.user_id == userId){
    document.getElementById('notifications-button').style.backgroundColor = "red";
    sendAjaxRequest('GET', '/notifications' , {}, handleRefreshNotifications);
  }
});

function handleRefreshNotifications() {
    if(this.status >= 200 && this.status < 400) {
      var data = JSON.parse(this.response);
      document.getElementById('notifications-list').innerHTML = "";
      console.log(data);
      data.notifications.forEach(notification => {
        if(!notification.viewed){
        const li = document.createElement('li');
        li.classList.add('notification');
        li.classList.add(notification.type);
        li.id = 'n' + notification.notification_id;
        if(notification.type == "invite") {
            let description_invite = document.createElement('p');
            description_invite.classList.add('notification-text');
            description_invite.textContent = "You have been invited to join the project ";
          
            const accept = document.createElement('button');
            accept.classList.add('invite-accept');
            accept.onclick = function() {
              accept_invite(notification.project_id, notification.notification_id, notification.emited_to);
          };
            const iconaccept = document.createElement('i');
            iconaccept.classList.add('fa-solid');
            iconaccept.classList.add('fa-check');
            accept.appendChild(iconaccept);
    
            const deny = document.createElement('button');
            deny.classList.add('notification-deny');
            deny.onclick = function() {
              dismiss_notification(notification.notification_id);
            };
            const icondeny = document.createElement('i');
            icondeny.classList.add('fa-solid');
            icondeny.classList.add('fa-ban');
            deny.appendChild(icondeny);
    
            li.appendChild(description_invite);
            li.appendChild(accept);
            li.appendChild(deny);
          }
          else if(notification.type == "acceptedinvite") {
              let description_accepted = document.createElement('p');
              description_accepted.classList.add('notification-text');
              description_accepted.textContent = "Your invite to the project has been accepted";

              const dismiss = document.createElement('button');
              dismiss.classList.add('notification-dismiss');
              dismiss.onclick = function() {
                dismiss_notification(notification.notification_id);
              };
              const icondismiss = document.createElement('i');
              icondismiss.classList.add('fa-solid');
              icondismiss.classList.add('fa-eye');

              dismiss.appendChild(icondismiss);

              li.appendChild(description_accepted);
              li.appendChild(dismiss);
          }
          else {
              let description_default = document.createElement('p');
              description_default.classList.add('notification-text');
              description_default.textContent = "default notification";
              li.appendChild(description_default);
          }

        document.getElementById('notifications-list').appendChild(li);
      }
      });
    }
}

  
