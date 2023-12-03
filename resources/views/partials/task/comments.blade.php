<div id="comments">
    <div class="comments-section">
        <div class="comment">       <!-- estrutura de um comentario -->
            <img src="" alt="">     <!-- imagem do user -->
            <p></p>                 <!-- conteudo -->
        </div>
    </div>
    <form class="comment-form" action="{{ route('task.complete') }}" method="POST">
        @csrf
        <input type="hidden" name="task_id" value="{{ $task->task_id }}">
        <textarea name="" id="" placeholder="Type comment"></textarea>
        <button id="submit-comment-button" type="submit" id="SubmitComment">Send</button>
    </form>
</div>