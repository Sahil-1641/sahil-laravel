<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_page_lists_projects_and_links_to_create(): void
    {
        $project = Project::create([
            'name' => 'Community Garden',
            'location' => 'North campus',
            'description' => 'A shared garden for students.',
        ]);

        $this->get(route('projects.index'))
            ->assertOk()
            ->assertSee('Community Garden')
            ->assertSee('North campus')
            ->assertSee(route('projects.create'))
            ->assertSee(route('projects.show', $project));
    }

    public function test_project_can_be_created(): void
    {
        $this->post(route('projects.store'), [
            'name' => 'Peer Tutoring',
            'location' => 'Library',
            'description' => 'Weekly study sessions.',
        ])
            ->assertRedirect(route('projects.show', 1))
            ->assertSessionHas('success', 'Project created successfully.');

        $this->assertDatabaseHas('projects', [
            'name' => 'Peer Tutoring',
            'location' => 'Library',
            'description' => 'Weekly study sessions.',
        ]);
    }

    public function test_project_creation_requires_all_fields(): void
    {
        $this->get(route('projects.create'))
            ->assertOk()
            ->assertSee('Project name')
            ->assertSee('Location')
            ->assertSee('Description');

        $this->from(route('projects.create'))
            ->post(route('projects.store'), [])
            ->assertRedirect(route('projects.create'))
            ->assertSessionHasErrors(['name', 'location', 'description']);

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_project_details_and_edit_form_are_available(): void
    {
        $project = Project::create([
            'name' => 'Campus Radio',
            'location' => 'Student Union',
            'description' => 'A student-run radio station.',
        ]);

        $this->get(route('projects.show', $project))
            ->assertOk()
            ->assertSee('A student-run radio station.')
            ->assertSee(route('projects.edit', $project))
            ->assertSee('Are you sure you want to delete this project?');

        $this->get(route('projects.edit', $project))
            ->assertOk()
            ->assertSee('Campus Radio')
            ->assertSee(route('projects.update', $project));
    }

    public function test_project_can_be_updated(): void
    {
        $project = Project::create([
            'name' => 'Old name',
            'location' => 'Old location',
            'description' => 'Old description.',
        ]);

        $this->put(route('projects.update', $project), [
            'name' => 'New name',
            'location' => 'New location',
            'description' => 'Updated description.',
        ])
            ->assertRedirect(route('projects.show', $project))
            ->assertSessionHas('success', 'Project updated successfully.');

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'New name',
            'location' => 'New location',
            'description' => 'Updated description.',
        ]);
    }

    public function test_project_update_requires_all_fields(): void
    {
        $project = Project::create([
            'name' => 'Existing project',
            'location' => 'Main campus',
            'description' => 'Keep these details unchanged.',
        ]);

        $this->from(route('projects.edit', $project))
            ->put(route('projects.update', $project), [])
            ->assertRedirect(route('projects.edit', $project))
            ->assertSessionHasErrors(['name', 'location', 'description']);

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Existing project',
            'location' => 'Main campus',
            'description' => 'Keep these details unchanged.',
        ]);
    }

    public function test_project_can_be_deleted(): void
    {
        $project = Project::create([
            'name' => 'Temporary project',
            'location' => 'South campus',
            'description' => 'This project will be removed.',
        ]);

        $this->delete(route('projects.destroy', $project))
            ->assertRedirect(route('projects.index'))
            ->assertSessionHas('success', 'Project deleted successfully.');

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
