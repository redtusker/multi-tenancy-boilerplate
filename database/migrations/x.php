<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaaSTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tenants Table
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('tenant_id')->primary();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        // TenantSettings Table
        Schema::create('tenant_settings', function (Blueprint $table) {
            $table->uuid('setting_id')->primary();
            $table->uuid('tenant_id');
            $table->string('setting_key');
            $table->json('setting_value');
            $table->timestamps();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
        });

        // TenantConfigurations Table
        Schema::create('tenant_configurations', function (Blueprint $table) {
            $table->uuid('configuration_id')->primary();
            $table->uuid('tenant_id');
            $table->string('configuration_key');
            $table->json('configuration_value');
            $table->timestamps();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
        });

        // Companies Table
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('company_id')->primary();
            $table->uuid('tenant_id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
        });

        // Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->uuid('company_id');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->string('role');
            $table->boolean('is_admin')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('company_id')->on('companies')->onDelete('cascade');
        });

        // ProductDefinitions Table
        Schema::create('product_definitions', function (Blueprint $table) {
            $table->uuid('product_id')->primary();
            $table->string('name');
            $table->string('description');
            $table->string('category');
            $table->string('type'); // core, addon, integration
            $table->timestamps();
            $table->softDeletes();
        });

        // ProductAttributes Table
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->uuid('attribute_id')->primary();
            $table->uuid('product_id');
            $table->string('attribute_name');
            $table->string('attribute_type');
            $table->timestamps();

            $table->foreign('product_id')->references('product_id')->on('product_definitions')->onDelete('cascade');
        });

        // CustomFields Table
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->uuid('custom_field_id')->primary();
            $table->string('entity_type');
            $table->string('field_name');
            $table->string('field_type');
            $table->timestamps();
        });

        // Quotations Table
        Schema::create('quotations', function (Blueprint $table) {
            $table->uuid('quotation_id')->primary();
            $table->uuid('tenant_id');
            $table->string('tenant_id');
            $table->uuid('company_id');
            $table->string('status'); // draft, pending, approved, rejected
            $table->text('terms_and_conditions');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
            $table->foreign('company_id')->references('company_id')->on('companies')->onDelete('cascade');
        });

        // QuotationItems Table
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->uuid('quotation_item_id')->primary();
            $table->uuid('quotation_id');
            $table->uuid('product_id');
            $table->integer('quantity');
            $table->decimal('price');
            $table->timestamps();

            $table->foreign('quotation_id')->references('quotation_id')->on('quotations')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('product_definitions')->onDelete('cascade');
        });

        // SubscriptionPlans Table
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->uuid('plan_id')->primary();
            $table->string('name');
            $table->string('description');
            $table->string('billing_cycle'); // monthly, yearly
            $table->boolean('auto_renew')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // PlanFeatures Table
        Schema::create('plan_features', function (Blueprint $table) {
            $table->uuid('feature_id')->primary();
            $table->uuid('plan_id');
            $table->string('feature_name');
            $table->string('feature_description');
            $table->timestamps();

            $table->foreign('plan_id')->references('plan_id')->on('subscription_plans')->onDelete('cascade');
        });

        // FeatureLimits Table
        Schema::create('feature_limits', function (Blueprint $table) {
            $table->uuid('limit_id')->primary();
            $table->uuid('feature_id');
            $table->string('limit_type'); // soft, hard
            $table->integer('limit_value');
            $table->timestamps();

            $table->foreign('feature_id')->references('feature_id')->on('plan_features')->onDelete('cascade');
        });

        // Subscriptions Table
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('subscription_id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('company_id');
            $table->uuid('plan_id');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('status'); // active, inactive, canceled
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
            $table->foreign('company_id')->references('company_id')->on('companies')->onDelete('cascade');
            $table->foreign('plan_id')->references('plan_id')->on('subscription_plans')->onDelete('cascade');
        });

        // FeatureUsage Table
        Schema::create('feature_usage', function (Blueprint $table) {
            $table->uuid('usage_id')->primary();
            $table->uuid('subscription_id');
            $table->uuid('feature_id');
            $table->integer('usage_value');
            $table->timestamp('usage_date');
            $table->timestamps();

            $table->foreign('subscription_id')->references('subscription_id')->on('subscriptions')->onDelete('cascade');
            $table->foreign('feature_id')->references('feature_id')->on('plan_features')->onDelete('cascade');
        });

        // BillingCycles Table
        Schema::create('billing_cycles', function (Blueprint $table) {
            $table->uuid('billing_cycle_id')->primary();
            $table->uuid('subscription_id');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->decimal('amount');
            $table->string('status'); // pending, paid, overdue
            $table->timestamps();

            $table->foreign('subscription_id')->references('subscription_id')->on('subscriptions')->onDelete('cascade');
        });

        // SubscriptionChanges Table
        Schema::create('subscription_changes', function (Blueprint $table) {
            $table->uuid('change_id')->primary();
            $table->uuid('subscription_id');
            $table->uuid('old_plan_id');
            $table->uuid('new_plan_id');
            $table->timestamp('change_date');
            $table->timestamps();

            $table->foreign('subscription_id')->references('subscription_id')->on('subscriptions')->onDelete('cascade');
            $table->foreign('old_plan_id')->references('plan_id')->on('subscription_plans')->onDelete('cascade');
            $table->foreign('new_plan_id')->references('plan_id')->on('subscription_plans')->onDelete('cascade');
        });

        // BillingModels Table
        Schema::create('billing_models', function (Blueprint $table) {
            $table->uuid('billing_model_id')->primary();
            $table->string('name');
            $table->string('description');
            $table->json('pricing_structure');
            $table->timestamps();
            $table->softDeletes();
        });

        // PricingRules Table
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->uuid('pricing_rule_id')->primary();
            $table->uuid('billing_model_id');
            $table->string('rule_name');
            $table->json('rule_logic');
            $table->timestamps();

            $table->foreign('billing_model_id')->references('billing_model_id')->on('billing_models')->onDelete('cascade');
        });

        // IntegrationConfigs Table
        Schema::create('integration_configs', function (Blueprint $table) {
            $table->uuid('integration_id')->primary();
            $table->uuid('tenant_id');
            $table->string('provider_name');
            $table->json('credentials');
            $table->string('status'); // active, inactive
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
        });

        // Notifications Table
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('notification_id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('user_id');
            $table->text('message');
            $table->string('status'); // unread, read
            $table->timestamps();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });

        // NotificationTemplates Table
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->uuid('template_id')->primary();
            $table->uuid('tenant_id');
            $table->string('template_name');
            $table->text('template_content');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
        });

        // AuditLogs Table
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('log_id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('user_id');
            $table->string('action');
            $table->string('entity_type');
            $table->uuid('entity_id');
            $table->json('details');
            $table->timestamps();

            $table->foreign('tenant_id')->references('tenant_id')->on('tenants')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('notification_templates');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('integration_configs');
        Schema::dropIfExists('pricing_rules');
        Schema::dropIfExists('billing_models');
        Schema::dropIfExists('subscription_changes');
        Schema::dropIfExists('billing_cycles');
        Schema::dropIfExists('feature_usage');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('feature_limits');
        Schema::dropIfExists('plan_features');
        Schema::dropIfExists('subscription_plans');
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('custom_fields');
        Schema::dropIfExists('product_attributes');
        Schema::dropIfExists('product_definitions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('tenant_configurations');
        Schema::dropIfExists('tenant_settings');
        Schema::dropIfExists('tenants');
    }
}
