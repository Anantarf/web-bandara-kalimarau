<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AuditLogObserver
{
    private const EXCLUDED_ATTRIBUTES = [
        'created_at',
        'updated_at',
        'password',
        'remember_token',
    ];

    public function created(Model $model): void
    {
        $this->record('created', $model, [], $model->getAttributes());
    }

    public function updated(Model $model): void
    {
        $changes = Arr::except($model->getChanges(), self::EXCLUDED_ATTRIBUTES);

        if ($changes === []) {
            return;
        }

        $this->record(
            'updated',
            $model,
            Arr::only($model->getOriginal(), array_keys($changes)),
            $changes,
        );
    }

    public function deleted(Model $model): void
    {
        $this->record('deleted', $model, $model->getOriginal(), []);
    }

    private function record(string $event, Model $model, array $oldValues, array $newValues): void
    {
        if (! auth()->check()) {
            return;
        }

        $request = request();

        AuditLog::query()->create([
            'user_id' => auth()->id(),
            'event' => $event,
            'auditable_type' => $model::class,
            'auditable_id' => $model->getKey(),
            'old_values' => $this->sanitize($oldValues),
            'new_values' => $this->sanitize($newValues),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    private function sanitize(array $values): array
    {
        return Arr::except($values, self::EXCLUDED_ATTRIBUTES);
    }
}
