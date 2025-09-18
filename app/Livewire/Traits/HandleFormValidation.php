<?php

namespace App\Livewire\Traits;

trait HandleFormValidation
{
    public function getErrorFor(string $field): ?string
    {
        return $this->getErrorBag()->first($field);
    }

    public function hasError(string $field): bool
    {
        return $this->getErrorBag()->has($field);
    }

    public function clearError(string $field): void
    {
        $this->resetErrorBag($field);
    }

    public function addFormError(string $field, string $message): void
    {
        $this->addError($field, $message);
    }

    protected function getValidationAttributes(): array
    {
        return [
            'form.title' => 'Titel',
            'form.original_title' => 'Originaltitel',
            'form.original_country' => 'Produktionsland',
            'form.original_language' => 'Originalsprache',
            'form.release_year' => 'Erscheinungsjahr',
            'form.duration_minutes' => 'Dauer in Minuten',
            'form.age_rating' => 'Altersfreigabe',
            'form.trailer_url' => 'Trailer-Link',
            'form.description' => 'Beschreibung',
            'form.poster_image' => 'Titelbild',
            'form.photos' => 'Fotos',
            'photos' => 'Fotos',
            'photos.*' => 'Foto',
        ];
    }

    protected function getValidationMessages(): array
    {
        return [
            'required' => 'Das Feld :attribute ist erforderlich.',
            'string' => 'Das Feld :attribute muss ein Text sein.',
            'integer' => 'Das Feld :attribute muss eine Zahl sein.',
            'min' => 'Das Feld :attribute muss mindestens :min sein.',
            'max' => 'Das Feld :attribute darf nicht größer als :max sein.',
            'url' => 'Das Feld :attribute muss eine gültige URL sein.',
            'image' => 'Das Feld :attribute muss ein Bild sein.',
            'mimes' => 'Das Feld :attribute muss eine Datei vom Typ :values sein.',
            'exists' => 'Der ausgewählte :attribute ist ungültig.',
            'array' => 'Das Feld :attribute muss eine Liste sein.',
        ];
    }
}
