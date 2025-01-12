@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4" x-data="chatRoom">
    <div class="flex flex-col h-[calc(100vh-12rem)]">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">{{ $group->name }}</h2>
            <button @click="showMembers = !showMembers" class="text-blue-600 hover:text-blue-800">
                Show Members
            </button>
        </div>

        <!-- Chat Container -->
        <div class="flex flex-1 gap-4">
            <!-- Messages Area -->
            <div class="flex-1 flex flex-col bg-white rounded-lg shadow-md">
                <!-- Messages List -->
                <div class="flex-1 p-4 overflow-y-auto" id="messages-container">
                    <template x-for="message in messages" :key="message.id">
                        <div :class="'flex mb-4 ' + (message.user_id == {{ auth()->id() }} ? 'justify-end' : 'justify-start')">
                            <div :class="'max-w-[70%] ' + (message.user_id == {{ auth()->id() }} ? 'bg-blue-500 text-white' : 'bg-gray-100') + ' rounded-lg p-3'">
                                <div class="font-semibold mb-1" x-text="message.user.name"></div>
                                
                                <!-- Message Content -->
                                <template x-if="message.type === 'text'">
                                    <p x-text="message.content"></p>
                                </template>
                                
                                <template x-if="message.type === 'image'">
                                    <div>
                                        <img :src="'/storage/' + message.file_path" class="max-w-full rounded">
                                        <p x-text="message.content" class="mt-2"></p>
                                    </div>
                                </template>
                                
                                <template x-if="message.type === 'file'">
                                    <div>
                                        <a :href="'/storage/' + message.file_path" 
                                           class="text-blue-600 hover:underline" 
                                           target="_blank" 
                                           x-text="message.file_name">
                                        </a>
                                        <p x-text="message.content" class="mt-2"></p>
                                    </div>
                                </template>
                                
                                <div class="text-xs mt-1" x-text="formatDate(message.created_at)"></div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Message Input -->
                <div class="p-4 border-t">
                    <form @submit.prevent="sendMessage" class="flex gap-2">
                        <input type="text" 
                               x-model="newMessage" 
                               class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Type your message...">
                        
                        <input type="file" 
                               @change="handleFileSelect" 
                               class="hidden" 
                               id="file-input"
                               accept="image/*,.pdf,.doc,.docx,.txt">
                        
                        <button type="button" 
                                @click="document.getElementById('file-input').click()"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Send
                        </button>
                    </form>
                </div>
            </div>

            <!-- Members Sidebar -->
            <div x-show="showMembers" 
                 class="w-64 bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold mb-4">Members</h3>
                <div class="space-y-2">
                    @foreach($group->members as $member)
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <span>{{ $member->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('chatRoom', () => ({
        messages: @json($messages),
        newMessage: '',
        showMembers: false,
        selectedFile: null,

        init() {
            Echo.join('chat.{{ $group->id }}')
                .here((users) => {
                    console.log('Here:', users);
                })
                .joining((user) => {
                    console.log('Joined:', user);
                })
                .leaving((user) => {
                    console.log('Left:', user);
                })
                .listen('NewChatMessage', (e) => {
                    this.messages.unshift(e.message);
                });

            this.scrollToBottom();
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = document.getElementById('messages-container');
                container.scrollTop = container.scrollHeight;
            });
        },

        handleFileSelect(event) {
            this.selectedFile = event.target.files[0];
        },

        async sendMessage() {
            if (!this.newMessage && !this.selectedFile) return;

            const formData = new FormData();
            if (this.newMessage) {
                formData.append('content', this.newMessage);
            }
            if (this.selectedFile) {
                formData.append('file', this.selectedFile);
            }

            try {
                const response = await fetch(`/chat/{{ $group->id }}/send`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const message = await response.json();
                this.messages.unshift(message);
                this.newMessage = '';
                this.selectedFile = null;
                document.getElementById('file-input').value = '';
                this.scrollToBottom();
            } catch (error) {
                console.error('Error sending message:', error);
            }
        },

        formatDate(date) {
            return new Date(date).toLocaleString();
        }
    }));
});
</script>
@endpush
@endsection
