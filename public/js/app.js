function addEventListeners() {

    let changePic = document.querySelector('#fileInput');
    if (changePic != null)
    changePic.addEventListener('change', handleFileSelect);

  /*
    let displayCreateTaskbtn = document.getElementById('CreateTaskButton');
    displayCreateTaskbtn.addEventListener('click', displayCreateTask);
  */
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
  

/*
  function displayCreateTask(event) {
    event.preventDefault();
    let createTaskElement = document.getElementById('createTask');
    createTaskElement.style.display = (createTaskElement.style.display === 'none') ? 'block' : 'none';
  }
*/

  document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        this.parentNode.parentNode.classList.toggle('selected', this.checked);
    });
  });


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


  function searchOnEnter(event) {
    if (event.key === 'Enter') {
        searchTasks();
    }
  }

  function searchProjects() {
      var input = document.getElementById('projectSearch');
      var filter = input.value;
      
  
      sendAjaxRequest('POST', '/search-projects', { filter: filter }, handleSearchProject);
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
  if (this.status >= 200 && this.status < 400) {
      var data = JSON.parse(this.response);
      var container = document.querySelector('#projects-container');
      var ul = document.querySelector('.projects-list');
      if (!ul) {
          ul = document.createElement('ul');
          ul.classList.add('projects-list');
          container.appendChild(ul);
      }
      ul.innerHTML = ''; 

      data.forEach(project => {
          var li = document.createElement('li');
          li.classList.add('project-item');

          var div = document.createElement('div');

          var a = document.createElement('a');
          a.href = '/project/' + project.project_id;
          a.classList.add('project-link');

          var title = document.createElement('h2');
          title.classList.add('project-title');
          title.textContent = project.title;
          div.appendChild(title);

          var description = document.createElement('p');
          description.classList.add('project-description');
          description.textContent = project.description;
          div.appendChild(description);


          li.appendChild(div);
          a.appendChild(li);
          ul.appendChild(a);
      });
  } else {
      console.error('Error:', this.status, this.statusText);
  }
}


function searchProjectsOnEnter(event) {
    if (event.key === 'Enter') {
        searchProjects();
    }
}

  function searchProjectsOnEnter(event) {
      if (event.key === 'Enter') {
          searchProjects();
      }
  }

  document.getElementById('projectSearch').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        searchProjects();
    }
  });

  addEventListeners();
