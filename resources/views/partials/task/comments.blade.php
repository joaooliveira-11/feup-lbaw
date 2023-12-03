<div id="comments">
    <div class="comments-section">
        @foreach($task->comments as $comment)
            <div class="comment" id="comment-{{ $comment->comment_id }}"> <!-- estrutura de um comentario -->
                <img src="" alt=""> <!-- imagem do user -->
                <p>{{ $comment->content }}</p> <!-- conteudo -->
                <p>{{ $comment->create_date }}</p> <!-- conteudo -->
                <p>{{ $comment->edited }}</p> <!-- conteudo -->
                <div class="comment-buttons">
                    <button type="button" class="comment-button">Edit</button>
                    <button type="button" class="comment-button">Delete</button>
                </div>
            </div>
        @endforeach
    </div>
    <form class="comment-form" id="createcommentform" action="{{ route('comment.create') }}" method="POST">
        @csrf
        <input type="hidden" name="task_id" value="{{ $task->task_id }}">
        <textarea name="content" id="comment-content" placeholder="Type comment" required></textarea>
        <div class="error" id="contentError"></div>
        <button id="submit-comment-button" type="submit">Send</button>
    </form>
</div>