<div id="Chat">
    <div id="{{auth()->user()->username}}" class="container chat-section">
        <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">
        @foreach($project->messages as $message)
            <div class="container message-chat" id="message-{{ $message->message_id }}">
                <img src="{{ url($message->messaged_by->photo) }}" class="user-image" alt="User Image"/> 
                <div class="message-content">
                    <h5 class="message-username">{{ $message->messaged_by->username }}</h5>
                    <p>{{ $message->content }}</p>
                    <div class="message-info-buttons">
                        <h6>{{ $message->create_date }}</h6>
                        @if ($message->edited == true)
                            <p>Edited</p>
                        @endif
                        <div class="message-buttons">
                            @if ($message->message_by == auth()->user()->id)
                                <button type="button" class="message-manage-button">Delete</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if($project->is_member(auth()->user()))
    <form class="container message-form {{ $project->archived ? 'archived-btn' : '' }}" id="createmessageform" action="{{ route('message.create') }}" method="POST">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->project_id}}">
        <textarea class="col-10" name="content" id="message-content" placeholder="Type message" required></textarea>
        <div class="error" id="contentError"></div>
        <button class="col-2" id="submit-message-button" type="submit">Send</button>
    </form>
    @endif
</div>
