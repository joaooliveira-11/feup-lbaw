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
    if (document.getElementById("submit-message-button")) {
      setupMessageForm("createmessageform");
    }

    let commentsSection = document.querySelector('.comments-section');
    if (commentsSection) {
    commentsSection.addEventListener('click', handleDeleteComment);
    }

    /*
    let chatSection = document.querySelector('.chat-section');
    if (chatSection) {
      chatSection.addEventListener('click', handleDeleteMessage);
    }
    */

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

      if (id === 'Chat') {
        let chatSection = document.querySelector('.chat-section');
        chatSection.scrollTop = chatSection.scrollHeight;
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

    let userImage = document.createElement('img');
    userImage.src = '/img/gmail.png'; // falta mudar para a imagem do user
    userImage.className = 'user-image';
    userImage.alt = 'Gmail Image';
    commentDiv.appendChild(userImage);

    let commentContentDiv = document.createElement('div');
    commentContentDiv.className = 'comment-content';

    let usernameH5 = document.createElement('h5');
    usernameH5.textContent = data.comment_comment_by;
    commentContentDiv.appendChild(usernameH5);

    let contentP = document.createElement('p');
    contentP.textContent = data.comment_content;
    commentContentDiv.appendChild(contentP);

    let commentInfoButtonsDiv = document.createElement('div');
    commentInfoButtonsDiv.className = 'comment-info-buttons';

    let createDate = new Date(data.comment_create_date);
    let formattedCreateDate = createDate.getFullYear() + '-' +
    String(createDate.getMonth() + 1).padStart(2, '0') + '-' +
    String(createDate.getDate()).padStart(2, '0') + ' ' +
    String(createDate.getHours()).padStart(2, '0') + ':' +
    String(createDate.getMinutes()).padStart(2, '0') + ':' +
    String(createDate.getSeconds()).padStart(2, '0');

    let createDateH6 = document.createElement('h6');
    createDateH6.textContent = formattedCreateDate;
    commentInfoButtonsDiv.appendChild(createDateH6);

    let commentButtonsDiv = document.createElement('div');
    commentButtonsDiv.className = 'comment-buttons';
    
    let deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'comment-manage-button';
    deleteButton.textContent = 'Delete';
    commentButtonsDiv.appendChild(deleteButton);
    
    commentInfoButtonsDiv.appendChild(commentButtonsDiv);

    commentContentDiv.appendChild(commentInfoButtonsDiv);
    commentDiv.appendChild(commentContentDiv);
    commentsSection.appendChild(commentDiv);
    document.getElementById('comment-content').value = '';

    commentsSection.scrollTop = commentsSection.scrollHeight;
  })
  .catch(error => console.error('Error:', error));
}

function handleCreateMessage(event) {
  event.preventDefault();

  if (!isMessageFormValid()) {
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
    let chatSection = document.querySelector('.chat-section');

    let messageDiv = document.createElement('div');
    messageDiv.className = 'message';
    messageDiv.id = 'message-' + data.message_id;

    let userImage = document.createElement('img');
    userImage.src = '/img/gmail.png'; // falta mudar para a imagem do user
    userImage.className = 'user-image';
    userImage.alt = 'Gmail Image';
    messageDiv.appendChild(userImage);

    let messageContentDiv = document.createElement('div');
    messageContentDiv.className = 'message-content';

    let usernameH5 = document.createElement('h5');
    usernameH5.textContent = data.message_message_by;
    messageContentDiv.appendChild(usernameH5);

    let contentP = document.createElement('p');
    contentP.textContent = data.message_content;
    messageContentDiv.appendChild(contentP);

    let messageInfoButtonsDiv = document.createElement('div');
    messageInfoButtonsDiv.className = 'message-info-buttons';

    let createDate = new Date(data.message_create_date);
    let formattedCreateDate = createDate.getFullYear() + '-' +
    String(createDate.getMonth() + 1).padStart(2, '0') + '-' +
    String(createDate.getDate()).padStart(2, '0') + ' ' +
    String(createDate.getHours()).padStart(2, '0') + ':' +
    String(createDate.getMinutes()).padStart(2, '0') + ':' +
    String(createDate.getSeconds()).padStart(2, '0');

    let createDateH6 = document.createElement('h6');
    createDateH6.textContent = formattedCreateDate;
    messageInfoButtonsDiv.appendChild(createDateH6);

    let messageButtonsDiv = document.createElement('div');
    messageButtonsDiv.className = 'message-buttons';
    
    let deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.className = 'message-manage-button';
    deleteButton.textContent = 'Delete';
    messageButtonsDiv.appendChild(deleteButton);
    
    messageInfoButtonsDiv.appendChild(messageButtonsDiv);

    messageContentDiv.appendChild(messageInfoButtonsDiv);
    messageDiv.appendChild(messageContentDiv);
    chatSection.appendChild(messageDiv);
    document.getElementById('message-content').value = '';

    chatSection.scrollTop = chatSection.scrollHeight;
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

function isMessageFormValid() {
  let content = document.getElementById("message-content").value;
  document.getElementById('contentError').innerHTML = '';

  if (content.length < 1 || content.length > 300) {
      document.getElementById('content').classList.add('validation-err');
      document.getElementById('contentError').innerHTML = 'Message content must be between 1 and 300 characters long';
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

function setupMessageForm(formId) {
  let form = document.getElementById(formId);
  document.getElementById(formId).addEventListener("submit", handleCreateMessage.bind(form));
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
  let commentsSection = document.querySelector(".comments-section");
  if (commentsSection) {
    commentsSection.scrollTop = commentsSection.scrollHeight;
  }
});

function handleDeleteComment(event) {
  if (event.target.classList.contains('comment-manage-button')) {
    let commentDiv = event.target.closest('.comment');
    let commentId = commentDiv.id.split('-')[1];
    let csrfToken = document.querySelector('#csrf-token').value;
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch('/comment/delete/' + commentId, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            commentDiv.remove();
          } 
        })
        .catch((error) => {
          console.error('Error:', error);
        });
      }
    })
  }
}
