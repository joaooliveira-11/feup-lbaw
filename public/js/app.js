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
      setupTaskForm("createtaskform", 'CreateTaskModalButton', 'ModalCreateTask');
    }
    if (document.getElementById("EditTaskModalButton")) {
      setupTaskForm("edittaskform", 'EditTaskModalButton', 'ModalEditTask');
    }
    if (document.getElementById("submit-comment-button")) {
      setupCommentForm("createcommentform");
    }
    
    setupRadioButtons();
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

function handleCreateTask(modalId, event) {
  event.preventDefault();

  if (!isTaskFormValid()) {
    return;
  }

  let url = this.getAttribute('action');
  let formData = new FormData(this);
  let csrfToken = document.querySelector('input[name="_token"]').value;

  fetch(url, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest', // This is to let Laravel know this is an AJAX request
      'X-CSRF-TOKEN': csrfToken,
    },
  })
  .then(response => response.json())
  .then(data => {
    let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
    modal.hide();

    let activeTasksCountElement = document.querySelector('#ActiveTasks p');
    activeTasksCountElement.textContent = parseInt(activeTasksCountElement.textContent) + 1;

    let newTask = document.createElement('li');
    newTask.innerHTML = `
      <a href="${data.task_url}" class="project-link task-link">
        <div>
          <p class="TaskTitle">${data.task_title}</p>
          <p>${data.task_description}</p>
          <p class="FinishDate">Deadline: ${data.task_finish_date !== null ? data.task_finish_date : 'Not defined'}</p>
        </div>
      </a>
    `;

    let tasksList = document.querySelector('.TasksList');
    if (!tasksList) {
      tasksList = document.createElement('ul');
      tasksList.className = 'TasksList';
      document.getElementById('tasks-container').appendChild(tasksList);
    }
    tasksList.appendChild(newTask);
  })
  .catch(error => console.error('Error:', error));
}


function handleEditTask(modalId, event) {
  event.preventDefault();

  if (!isTaskFormValid()) {
    return;
  }

  let url = this.getAttribute('action');
  let formData = new FormData(this);
  formData.append('_method', 'PATCH');
  let csrfToken = document.querySelector('input[name="_token"]').value;

  fetch(url, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest', // This is to let Laravel know this is an AJAX request
      'X-CSRF-TOKEN': csrfToken,
    },
  })
  .then(response => response.json())
  .then(data => {
    let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
    modal.hide();
    
    let titleNode = document.createTextNode(data.task_title);
    let finishDate = new Date(data.task_finish_date);
    let formattedFinishDate = finishDate.getFullYear() + '-' +
      String(finishDate.getMonth() + 1).padStart(2, '0') + '-' +
      String(finishDate.getDate()).padStart(2, '0') + ' ' +
      String(finishDate.getHours()).padStart(2, '0') + ':' +
      String(finishDate.getMinutes()).padStart(2, '0') + ':' +
      String(finishDate.getSeconds()).padStart(2, '0');
      let finishDateNode = document.createTextNode(formattedFinishDate);
      let priorityNode = document.createTextNode(data.task_priority);

    let titleElement = document.getElementById('task-details-title');
    let finishDateElement = document.getElementById('task-details-finish_date');
    let priorityElement = document.getElementById('task-details-priority');

    titleElement.parentNode.replaceChild(titleNode, titleElement.nextSibling);
    finishDateElement.parentNode.replaceChild(finishDateNode, finishDateElement.nextSibling);
    priorityElement.parentNode.replaceChild(priorityNode, priorityElement.nextSibling);
    
    document.querySelector('#task-description p').textContent = data.task_description;
  })
  .catch(error => console.error('Error:', error));
}

function handleCreateComment(event) {
  event.preventDefault();

  if (!isCommentFormValid()) {
    return;
  }

  let url = this.getAttribute('action');
  let formData = new FormData(this);
  let csrfToken = document.querySelector('input[name="_token"]').value;

  fetch(url, {
    method: 'POST',
    body: formData,
    headers: {
      'X-Requested-With': 'XMLHttpRequest', // This is to let Laravel know this is an AJAX request
      'X-CSRF-TOKEN': csrfToken,
    },
  })
  .then(response => response.json())
  .then(data => {
    let commentsSection = document.querySelector('.comments-section');

    let commentDiv = document.createElement('div');
    commentDiv.className = 'comment';
    commentDiv.id = 'comment-' + data.comment_id;

    let contentP = document.createElement('p');
    contentP.textContent = data.comment_content;
    commentDiv.appendChild(contentP);

    let createDateP = document.createElement('p');
    createDateP.textContent = data.create_date;
    commentDiv.appendChild(createDateP);

    let editedP = document.createElement('p');
    editedP.textContent = data.comment_edited;
    commentDiv.appendChild(editedP);

    commentsSection.appendChild(commentDiv);
    document.getElementById('comment-content').value = '';
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

function isCommentFormValid() {
  let content = document.getElementById("comment-content").value;

  document.getElementById('contentError').innerHTML = '';

  if (content.length < 1 || content.length > 300) {
      document.getElementById('content').classList.add('validation-err');
      document.getElementById('contentError').innerHTML = 'Comment content must be between 1 and 300 characters long';
      return false;
  }

  return true;
}

function setupTaskForm(formId, buttonId, modalId) {
  let form = document.getElementById(formId);
  switch (formId) {
    case 'createtaskform':
      document.getElementById(formId).addEventListener("submit", handleCreateTask.bind(form, modalId));
      break;
    case 'edittaskform':
      document.getElementById(formId).addEventListener("submit", handleEditTask.bind(form, modalId));
      break;
  }
  document.getElementById(buttonId).addEventListener('click', function () {
    let modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
  });
}

function setupCommentForm(formId) {
  let form = document.getElementById(formId);
  document.getElementById(formId).addEventListener("submit", handleCreateComment.bind(form));
}

document.addEventListener("DOMContentLoaded", function () {
  addEventListeners();
});
  
