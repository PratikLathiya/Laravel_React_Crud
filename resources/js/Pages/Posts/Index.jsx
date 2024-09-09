import React, { useState } from 'react';
import { Link } from '@inertiajs/react';
import { Inertia } from '@inertiajs/inertia';

export default function Index({ posts }) {
    const [expandedPosts, setExpandedPosts] = useState({});

    const toggleExpand = (id) => {
        setExpandedPosts(prev => ({
            ...prev,
            [id]: !prev[id]
        }));
    };

    const handleDelete = (id) => {
        if (window.confirm('Are you sure you want to delete this post?')) {
            Inertia.delete(route('posts.destroy', id));
        }
    };

    return (
        <div className="py-12">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="p-6 bg-white border-b border-gray-200">
                        <div className="flex justify-between items-center mb-6">
                            <h1 className="text-2xl font-semibold text-gray-900">Posts</h1>
                            <Link href={route('posts.create')} className="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">Create New Post</Link>
                        </div>
                        {posts.length === 0 ? (
                            <p>No posts found.</p>
                        ) : (
                            <div className="space-y-6">
                                {posts.map(post => (
                                    <div key={post.id} className="bg-white rounded-lg shadow-md overflow-hidden">
                                        <div className="p-6">
                                            <h2 className="text-xl font-semibold mb-2">{post.title}</h2>
                                            <div className={`text-gray-600 mb-4 ${expandedPosts[post.id] ? '' : 'line-clamp-3'}`}>
                                                {post.content}
                                            </div>
                                            {post.content.length > 150 && (
                                                <button 
                                                    onClick={() => toggleExpand(post.id)}
                                                    className="text-blue-500 hover:text-blue-700 mb-4"
                                                >
                                                    {expandedPosts[post.id] ? 'Show less' : 'Show more'}
                                                </button>
                                            )}
                                            <div className="flex justify-end space-x-2">
                                                <Link href={route('posts.edit', post.id)} className="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300">Edit</Link>
                                                <button onClick={() => handleDelete(post.id)} className="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}