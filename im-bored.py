import pygame

pygame.init()

screen = pygame.display.set_mode((720, 480), pygame.RESIZABLE)
clock = pygame.time.Clock()

box = pygame.Rect(0, 0, 100, 100)
box.midtop = (screen.get_width() / 2, 0)

speed = 6
gravity = 0.5
velocity = 0
is_grounded = False
is_crouched = False
mousedown = False
is_being_dragged = False
can_wall_jump = True  # Track whether wall jump is allowed
jump_vel = 20

running = True
while running:
    jump_requested = False

    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False
        elif event.type == pygame.MOUSEBUTTONDOWN:
            if event.button == 1:
                mousedown = True
                if box.collidepoint(event.pos):
                    is_being_dragged = True
        elif event.type == pygame.MOUSEBUTTONUP:
            if event.button == 1:
                mousedown = False
                is_being_dragged = False
        elif event.type == pygame.KEYDOWN:
            if event.key in (pygame.K_SPACE, pygame.K_w, pygame.K_UP):
                jump_requested = True

    keys = pygame.key.get_pressed()

    # --- Horizontal Movement ---
    if keys[pygame.K_a] or keys[pygame.K_LEFT]:
        if box.x >= 0:
            box.x -= speed
    if keys[pygame.K_d] or keys[pygame.K_RIGHT]:
        if box.x <= screen.get_width() - box.w:
            box.x += speed

    # --- Crouching ---
    if keys[pygame.K_s] or keys[pygame.K_DOWN]:
        if not is_crouched:
            box.height = 50
            box.y += 50
            is_crouched = True
    else:
        if is_crouched:
            box.height = 100
            box.y -= 50
            is_crouched = False

    # --- Boundaries & Environmental Checks ---
    ground_y = screen.get_height()
    touching_wall = (box.left <= 0 or box.right >= screen.get_width())

    # Reset wall jump capability when leaving the wall
    if not touching_wall:
        can_wall_jump = True

    # --- Mouse Dragging vs Gravity & Jumping ---
    if is_being_dragged:
        box.center = pygame.mouse.get_pos()
        velocity = 0
        is_grounded = False
        can_wall_jump = True
    else:
        # Jump check (ground OR single wall jump)
        if jump_requested:
            if is_grounded:
                velocity = jump_vel
                is_grounded = False
            elif touching_wall and can_wall_jump:
                velocity = jump_vel
                can_wall_jump = False  # Lock wall jump until leaving wall or touching floor
                is_grounded = False

        # Continuous gravity when in mid-air
        if not is_grounded:
            velocity -= gravity
            box.y -= velocity

        # Ground collision
        if box.bottom >= ground_y:
            box.bottom = ground_y
            velocity = 0
            is_grounded = True
            can_wall_jump = True  # Reset wall jump capability upon touching floor

    # --- Render ---
    screen.fill((0, 0, 0))
    pygame.draw.rect(screen, (255, 0, 0), box)

    pygame.display.flip()
    clock.tick(60)

pygame.quit()