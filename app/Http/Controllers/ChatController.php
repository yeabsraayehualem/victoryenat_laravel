<?php

namespace App\Http\Controllers;

use App\Models\ChatGroup;
use App\Models\ChatMessage;
use App\Events\NewChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $groups = $user->chatGroups;
        return view('chat.index', compact('groups'));
    }

    public function show(ChatGroup $group)
    {
        $this->authorize('view', $group);
        $messages = $group->messages()->with('user')->latest()->paginate(50);
        return view('chat.show', compact('group', 'messages'));
    }

    public function sendMessage(Request $request, ChatGroup $group)
    {
        $this->authorize('sendMessage', $group);
        
        $validated = $request->validate([
            'content' => 'required_without:file|string|nullable',
            'file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        $messageData = [
            'user_id' => Auth::id(),
            'chat_group_id' => $group->id,
            'content' => $request->content ?? '',
            'type' => 'text'
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('chat-files');
            
            $messageData['file_path'] = $path;
            $messageData['file_name'] = $file->getClientOriginalName();
            $messageData['file_size'] = $file->getSize();
            $messageData['type'] = str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'file';
        }

        $message = ChatMessage::create($messageData);

        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json($message->load('user'));
    }

    public function getMessages(ChatGroup $group, Request $request)
    {
        $this->authorize('view', $group);
        $messages = $group->messages()
            ->with('user')
            ->where('id', '<', $request->before_id)
            ->latest()
            ->limit(50)
            ->get();
        
        return response()->json($messages);
    }
}
