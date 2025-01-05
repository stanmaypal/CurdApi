
Post Management API
This project is a Post Management API that allows users to create, read, update, and delete posts. It provides a simple way to manage posts with fields for the title, content, and timestamps. The API is built using Laravel and follows RESTful principles.

Features
CRUD Operations:

Create a new post
Retrieve all posts
Update an existing post
Delete a post
Dark Mode: The frontend allows users to toggle between dark and light modes.

Modals: The Add and Edit Post forms are presented in modals for a smooth user experience.

Technologies Used
Backend: Laravel (PHP)
Frontend: HTML, CSS, Bootstrap, Axios
Database: MySQL (or any compatible database)
Authentication: Token-based authentication (if applicable)
Installation
1. Clone the Repository
bash
Copy code
git clone <repository-url>
cd <project-directory>
2. Install Dependencies
bash
Copy code
composer install
npm install
3. Set Up Environment
Copy .env.example to .env and configure your database connection.
bash
Copy code
cp .env.example .env
php artisan key:generate
4. Database Migration
Run the following command to set up the database and required tables:

bash
Copy code
php artisan migrate
5. Run the Application
Start the Laravel development server:

bash
Copy code
php artisan serve
The application will be available at http://localhost:8000.

API Endpoints
1. Create a New Post
URL: /api/posts

Method: POST

Request Body:

json
Copy code
{
    "title": "Post Title",
    "content": "Post Content"
}
Response:

json
Copy code
{
    "message": "Post created successfully"
}
2. Get All Posts
URL: /api/posts
Method: GET
Response:
json
Copy code
[
    {
        "id": 1,
        "title": "Post Title",
        "content": "Post Content",
        "created_at": "2025-01-01 12:00:00",
        "updated_at": "2025-01-01 12:00:00"
    },
    ...
]
3. Update a Post
URL: /api/posts/{id}

Method: PUT

Request Body:

json
Copy code
{
    "title": "Updated Title",
    "content": "Updated Content"
}
Response:

json
Copy code
{
    "message": "Post updated successfully"
}
4. Delete a Post
URL: /api/posts/{id}
Method: DELETE
Response:
json
Copy code
{
    "message": "Post deleted successfully"
}
Integration Instructions
Frontend Integration
Fetch Posts: Use GET /api/posts to fetch the list of posts and display them in the table.

Add/Edit Post:

Use POST /api/posts to create a new post.
Use PUT /api/posts/{id} to update an existing post.
Delete Post:

Use DELETE /api/posts/{id} to delete a post.
Dark Mode:

Toggle between light and dark modes using the button provided on the frontend.
API Integration with Frontend
Use Axios for making API requests. Here's an example:
javascript
Copy code
axios.post('/api/posts', {
    title: 'New Post Title',
    content: 'New Post Content'
})
.then(response => {
    alert(response.data.message);
    fetchPosts();
})
.catch(error => {
    console.error('Error creating post:', error);
});
Contribution
If you'd like to contribute to this project, please fork the repository, create a branch, make your changes, and submit a pull request.

License
This project is licensed under the MIT License.

Let me know if you'd like me to create the README file!