<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task CRUD using Fetch</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f8fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 32px 24px 24px 24px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 24px;
        }
        #addTaskBtn {
            display: block;
            margin: 0 auto 24px auto;
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }
        #addTaskBtn:hover {
            background: #1d4ed8;
        }
        #tasksList {
            margin-top: 12px;
        }
        .task-item {
            background: #f3f4f6;
            border-radius: 6px;
            padding: 14px 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .task-info {
            flex: 1;
        }
        .task-title {
            font-weight: bold;
            color: #222;
            margin-bottom: 4px;
        }
        .task-desc {
            color: #555;
            font-size: 15px;
        }
        .task-actions button {
            margin-left: 8px;
            padding: 6px 14px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .task-actions .edit-btn {
            background: #fbbf24;
            color: #fff;
        }
        .task-actions .edit-btn:hover {
            background: #f59e42;
        }
        .task-actions .delete-btn {
            background: #ef4444;
            color: #fff;
        }
        .task-actions .delete-btn:hover {
            background: #dc2626;
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0; top: 0;
            width: 100%; height: 100%;
            overflow: auto;
            background: rgba(0,0,0,0.3);
        }
        .modal-content {
            background: #fff;
            margin: 80px auto;
            padding: 24px 24px 16px 24px;
            border-radius: 8px;
            max-width: 400px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            position: relative;
        }
        .close-modal {
            position: absolute;
            right: 16px;
            top: 12px;
            font-size: 22px;
            color: #888;
            cursor: pointer;
        }
        #taskForm {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        #taskForm input[type="text"],
        #taskForm textarea {
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            font-size: 16px;
            background: #f9fafb;
            resize: vertical;
        }
        #taskForm button[type="submit"] {
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 10px 0;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }
        #taskForm button[type="submit"]:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Task CRUD using Fetch</h2>
        <button id="addTaskBtn">Add Task</button>

        <div id="tasksList"></div>
    </div>

    <!-- Modal -->
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" id="closeModalBtn">&times;</span>
            <form id="taskForm">
                <input type="hidden" id="task_id">
                <input type="text" id="title" placeholder="Title" required>
                <textarea id="description" placeholder="Description" rows="3"></textarea>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

<script>
const csrf = document.querySelector('meta[name="csrf-token"]').content;

function headers(){
    return {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": csrf
    };
}

// Modal logic
const modal = document.getElementById('taskModal');
const addTaskBtn = document.getElementById('addTaskBtn');
const closeModalBtn = document.getElementById('closeModalBtn');
const taskForm = document.getElementById('taskForm');

function openModal(){
    modal.style.display = 'block';
}
function closeModal(){
    modal.style.display = 'none';
    taskForm.reset();
    document.getElementById("task_id").value = "";
}
addTaskBtn.onclick = function() {
    openModal();
};
closeModalBtn.onclick = function() {
    closeModal();
};
window.onclick = function(event) {
    if (event.target == modal) closeModal();
};

// Load tasks
async function loadTasks(){
    const res = await fetch('/tasks', { headers: { "Accept":"application/json" } });
    const tasks = await res.json();
    document.getElementById("tasksList").innerHTML = tasks.length
        ? tasks.map(t => `
            <div class="task-item">
                <div class="task-info">
                    <div class="task-title">${t.title}</div>
                    <div class="task-desc">${t.description || ""}</div>
                </div>
                <div class="task-actions">
                    <button class="edit-btn" onclick="editTask(${t.id})">Edit</button>
                    <button class="delete-btn" onclick="deleteTask(${t.id})">Delete</button>
                </div>
            </div>
        `).join('')
        : '<div style="text-align:center;color:#888;">No tasks found.</div>';
}

// Create/Update
taskForm.addEventListener("submit", async e=>{
    e.preventDefault();
    const id = document.getElementById("task_id").value;
    const payload = {
        title: document.getElementById("title").value,
        description: document.getElementById("description").value
    };
    const url = id ? `/tasks/${id}` : '/tasks';
    const method = id ? "PUT" : "POST";

    await fetch(url, { method, headers: headers(), body: JSON.stringify(payload) });
    closeModal();
    loadTasks();
});

// Edit
window.editTask = async function(id){
    const res = await fetch(`/tasks/${id}`);
    const t = await res.json();
    document.getElementById("task_id").value = t.id;
    document.getElementById("title").value = t.title;
    document.getElementById("description").value = t.description;
    openModal();
}

// Delete
window.deleteTask = async function(id){
    await fetch(`/tasks/${id}`, { method:"DELETE", headers: headers() });
    loadTasks();
}

loadTasks();
</script>
</body>
</html>
