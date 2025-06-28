<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_name',
        'contact_person',
        'phone',
        'billing_address',
        'tax_id',
        'payment_terms',
        'notes'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function domains()
    {
        return $this->hasMany(ClientDomain::class);
    }

    public function employees()
    {
        return $this->hasMany(ClientEmployee::class);
    }

    public function projects()
    {
        return $this->hasManyThrough(
            Project::class,
            ClientEmployee::class,
            'client_id', // Foreign key on ClientEmployee table
            'requested_by', // Foreign key on Project table
            'id', // Local key on Client table
            'id' // Local key on ClientEmployee table
        );
    }

    public function translationMemories()
    {
        return $this->hasMany(TranslationMemory::class);
    }

    public function glossaryTerms()
    {
        return $this->hasMany(GlossaryTerm::class);
    }
}
