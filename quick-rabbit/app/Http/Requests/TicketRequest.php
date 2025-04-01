<?php
/*
  ##############################################################################
  # AI Powered Customer Support Portal and Knowledgebase System
  ##############################################################################
  # AUTHOR:		Door Soft
  ##############################################################################
  # EMAIL:		info@doorsoft.co
  ##############################################################################
  # COPYRIGHT:		RESERVED BY Door Soft
  ##############################################################################
  # WEBSITE:		https://www.doorsoft.co
  ##############################################################################
  # This is Ticket Requests
  ##############################################################################
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_category_id' => 'required',
            'customer_id' => 'required',
            'title' => 'required|max:255',
            'priority' => 'required',
            'ticket_content' => 'required',
        ];
    }

    /**
     * Get the validation rules message to the request
     * @returns array
     */
    public function messages(): array
    {
        return [
            'product_category_id.required' => __('index.product_category_id.required'),
            'customer_id.required' => __('index.customer_id_required'),
            'title.required' => __('index.title.required'),
            'title.max' => __('index.title.max'),
            'priority.required' => __('index.priority.required'),
            'ticket_content.required' => __('index.ticket_content.required')
        ];
    }
}
