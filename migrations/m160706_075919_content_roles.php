<?php

use jarrus90\User\migrations\RbacMigration;

class m160706_075919_content_roles extends RbacMigration {

    public function up() {
        
        $admin = $this->authManager->getRole('admin');
        $adminSuper = $this->authManager->getRole('admin_super');
        $adminContent = $this->authManager->getRole('admin_content');
        
        $contentAdmin = $this->createRole('content_admin', 'Cms administrator role');
        $contentPublisher = $this->createRole('content_publisher', 'Cms publisher role');
        $this->assignChildRole($contentPublisher, $admin);
        $this->assignChildRole($contentAdmin, $contentPublisher);
        $this->assignChildRole($adminContent, $contentPublisher);
        $this->assignChildRole($adminSuper, $contentAdmin);
    }

    public function down() {
        
    }

}
