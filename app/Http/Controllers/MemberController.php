<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->paginate(10);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(Member $member)
    {
        $member->load(['borrowings.details.book']);
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'status' => 'required|in:active,inactive'
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil diupdate!');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }
}