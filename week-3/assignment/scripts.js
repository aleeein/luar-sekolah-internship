document.addEventListener("DOMContentLoaded", () => {
  // ------- Programs Page Functionality -------

  // Program data (could be from an API in the future)
  const programs = [
    {
      title: "Resume Building",
      category: "Workshops",
      description: "Assistance with creating and optimizing resumes.",
    },
    {
      title: "Interview Skills",
      category: "Workshops",
      description: "Training on interview techniques and strategies.",
    },
    {
      title: "Networking",
      category: "Workshops",
      description: "Tips and best practices for professional networking.",
    },
    {
      title: "Coding Bootcamps",
      category: "Technical",
      description:
        "Intensive programs for learning programming languages and technologies.",
    },
    {
      title: "Software Tools Training",
      category: "Technical",
      description:
        "Courses on popular software tools and platforms (e.g., Excel, SQL, Python).",
    },
    {
      title: "Certifications",
      category: "Technical",
      description:
        "Preparation for industry-recognized certifications (e.g., AWS, PMP).",
    },
    {
      title: "Leadership Training",
      category: "Leadership",
      description:
        "Courses on leadership styles, team management, and decision-making.",
    },
    {
      title: "Project Management",
      category: "Leadership",
      description: "Training on project management methodologies and tools.",
    },
    {
      title: "Effective Communication",
      category: "Leadership",
      description:
        "Workshops on improving communication skills within a team or organization.",
    },
  ];

  const programContainer = document.getElementById("program-cards-container");
  const searchBar = document.getElementById("search-bar");

  // Function to display programs as cards
  function displayPrograms(programsToDisplay) {
    if (programContainer) {
      // Ensure this code runs only if the program container exists
      programContainer.innerHTML = ""; // Clear existing content

      programsToDisplay.forEach((program) => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
          <h3>${program.title}</h3>
          <p>${program.description}</p>
          <small>Category: ${program.category}</small>
        `;
        programContainer.appendChild(card);
      });
    }
  }

  // Display all programs initially (only if programContainer exists)
  if (programContainer) {
    displayPrograms(programs);
  }

  // Filter programs by category
  document.querySelectorAll(".filter-container button").forEach((button) => {
    button.addEventListener("click", () => {
      const category = button.getAttribute("data-category");
      const filteredPrograms =
        category === "All"
          ? programs
          : programs.filter((prog) => prog.category === category);
      displayPrograms(filteredPrograms);
    });
  });

  // Search functionality
  if (searchBar) {
    searchBar.addEventListener("keyup", (event) => {
      const query = event.target.value.toLowerCase();
      const filteredPrograms = programs.filter(
        (prog) =>
          prog.title.toLowerCase().includes(query) ||
          prog.description.toLowerCase().includes(query)
      );
      displayPrograms(filteredPrograms);
    });
  }

  // ------- Login Page Functionality -------

  const loginForm = document.querySelector("form");

  if (loginForm) {
    loginForm.addEventListener("submit", (event) => {
      event.preventDefault(); // Prevent form from submitting

      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();

      // Basic validation example
      if (username === "" || password === "") {
        alert("Both fields are required.");
      } else if (username.length < 3 || password.length < 5) {
        alert(
          "Username must be at least 3 characters and password at least 5 characters long."
        );
      } else {
        alert("Login successful!");
        // Here, you can add actual login logic or redirect
      }
    });
  }
});
