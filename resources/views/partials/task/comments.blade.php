<div id="comments">
    <div class="comments-section">
        @foreach($task->comments as $comment)
            <div class="comment" id="comment-{{ $comment->comment_id }}">
            <img src="{{ url('/img/gmail.png') }}" class="user-image" alt="Gmail Image"/> <!-- imagem do user -->
                <div class="comment-content">
                    <p>{{ $comment->content }}</p>
                    <div class="comment-info-buttons">
                        <h6>{{ $comment->create_date }}</h6>
                        @if ($comment->edited == true)
                            <p>Edited</p>
                        @endif
                        <div class="comment-buttons">
                            <button type="button" class="comment-manage-button">Edit</button>
                            <button type="button" class="comment-manage-button">Delete</button>
                        </div>
                    </div>
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