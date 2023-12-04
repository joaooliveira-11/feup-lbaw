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
  document.getElementById(formId).addEventListener("submit", handleTaskFormSubmit.bind(form, modalId, viewsToUpdate));

  document.getElementById(buttonId).addEventListener('click', function () {
    let modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
  });
}

document.addEventListener("DOMContentLoaded", function () {
  addEventListeners();
});
  
