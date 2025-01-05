<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Management || Sarvesh Pal</title>
    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        .dark-mode .card, .dark-mode .modal-content, .dark-mode .table {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 8px;
        }

        .btn-gradient {
            background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            color: #fff;
        }

        .btn-gradient:hover {
            background: linear-gradient(90deg, #2575fc 0%, #6a11cb 100%);
        }

        table {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        table th, table td {
            vertical-align: middle;
        }

        .dark-mode .btn-gradient {
            background: linear-gradient(90deg, #d53369 0%, #daae51 100%);
        }

        .btn-dark-mode {
            background: #6c757d;
            border: none;
            color: #fff;
        }

        .btn-dark-mode:hover {
            background: #5a6268;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .dark-mode .table-hover tbody tr:hover {
            background-color: #2c2c2c;
        }

        .modal-content {
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Post Management</h2>
            <button id="toggleMode" class="btn btn-dark-mode">Toggle Dark Mode</button>
        </div>
        <button class="btn btn-gradient mb-3" onclick="openModal()">+ Add Post</button>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody id="postsTableBody">
                <!-- Data will be dynamically inserted here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="postForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel">Add Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="postId">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-gradient" id="submitButton">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and Axios -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Dark mode toggle logic
    const toggleModeButton = document.getElementById('toggleMode');

    const applyTheme = (theme) => {
        document.body.classList.toggle('dark-mode', theme === 'dark');
        toggleModeButton.textContent = theme === 'dark' ? 'Switch to Light Mode' : 'Switch to Dark Mode';
        localStorage.setItem('theme', theme);
    };

    const currentTheme = localStorage.getItem('theme') || 'light';
    applyTheme(currentTheme);

    toggleModeButton.addEventListener('click', () => {
        const newTheme = document.body.classList.contains('dark-mode') ? 'light' : 'dark';
        applyTheme(newTheme);
    });

    // Fetch and display posts (same logic as before)
    const fetchPosts = () => {
        axios.get('/api/posts')
            .then(response => {
                const postsTableBody = document.getElementById('postsTableBody');
                postsTableBody.innerHTML = ''; // Clear the table body before appending
                response.data.forEach(post => {
                    postsTableBody.innerHTML += `
                        <tr>
                            <td>${post.id}</td>
                            <td>${post.title}</td>
                            <td>${post.content}</td>
                            <td>${new Date(post.created_at).toLocaleString()}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="openModal(${post.id}, '${post.title}', '${post.content}')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deletePost(${post.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => {
                console.error('Error fetching posts:', error);
            });
    };

    const openModal = (id = null, title = '', content = '') => {
        const modal = new bootstrap.Modal(document.getElementById('postModal'));
        document.getElementById('postId').value = id || '';
        document.getElementById('title').value = title;
        document.getElementById('content').value = content;
        document.getElementById('postModalLabel').innerText = id ? 'Edit Post' : 'Add Post';
        document.getElementById('submitButton').innerText = id ? 'Update' : 'Submit';
        modal.show();
    };

    document.getElementById('postForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const postId = document.getElementById('postId').value;
        const formData = {
            title: document.getElementById('title').value,
            content: document.getElementById('content').value
        };

        const apiUrl = postId ? `/api/posts/${postId}` : '/api/posts';
        const method = postId ? 'put' : 'post';

        axios[method](apiUrl, formData)
            .then(response => {
                document.getElementById('postModal').querySelector('.btn-close').click(); // Close modal
                fetchPosts(); // Refresh table
                alert(response.data.message);
            })
            .catch(error => {
                console.error('Error submitting form:', error);
            });
    });

    const deletePost = (id) => {
        if (confirm('Are you sure you want to delete this post?')) {
            axios.delete(`/api/posts/${id}`)
                .then(response => {
                    fetchPosts();
                    alert(response.data.message);
                })
                .catch(error => {
                    console.error('Error deleting post:', error);
                });
        }
    };

    // Fetch all posts when the page loads
    window.onload = fetchPosts;
</script>
</body>
</html>
