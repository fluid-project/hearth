<?php

namespace App\Http\Requests;

use Hearth\Models\Membership;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateMembershipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->membership->membershipable());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'role' => [
                'required',
                'string',
                Rule::in(config('hearth.organizations.roles')),
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator
            ->after($this->ensureLastAdminIsNotLosingPrivileges($this->membership));
    }

    /**
     *
     * @param Membership $membership
     * @return \Closure
     */
    public function ensureLastAdminIsNotLosingPrivileges(Membership $membership): \Closure
    {
        return function ($validator) use ($membership) {
            if (
                $membership->membershipable()->administrators->count() === 1
                && $membership->role === 'admin'
                && $validator->safe()->only('role') !== 'admin'
            ) {
                $validator->errors()->add(
                    'role',
                    __('validation.custom.membership.not_last_admin')
                );
            }
        };
    }
}
