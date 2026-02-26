import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/models/project_model.dart';
import 'package:sngpbad_dashboard/services/project_service.dart';

class Projects extends StatefulWidget {
  const Projects({super.key});

  @override
  State<Projects> createState() => _ProjectsState();
}

class _ProjectsState extends State<Projects> {
  final ProjectService _projectService = ProjectService();
  List<ProjectModel> _allProjects = [];
  List<ProjectModel> _filteredProjects = [];
  bool _isLoading = true;
  final TextEditingController _searchController = TextEditingController();

  final Color primaryBlue = const Color(0xFF1B4F72);

  @override
  void initState() {
    super.initState();
    _fetchProjects();
  }

  Future<void> _fetchProjects() async {
    final projects = await _projectService.fetchProjects();
    setState(() {
      _allProjects = projects;
      _filteredProjects = projects;
      _isLoading = false;
    });
  }

  void _filterProjects(String query) {
    setState(() {
      _filteredProjects = _allProjects
          .where((p) =>
              p.nom.toLowerCase().contains(query.toLowerCase()) ||
              p.code.toLowerCase().contains(query.toLowerCase()))
          .toList();
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F7F6),
      body: Padding(
        padding: const EdgeInsets.all(30.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            _buildHeader(),
            const SizedBox(height: 30),
            _buildSearchBar(),
            const SizedBox(height: 20),
            Expanded(
              child: _isLoading
                  ? const Center(child: CircularProgressIndicator())
                  : _buildProjectList(),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildHeader() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          "Portefeuille des Projets",
          style: GoogleFonts.montserrat(
            fontSize: 24,
            fontWeight: FontWeight.bold,
            color: primaryBlue,
          ),
        ),
        Text(
          "Liste exhaustive des opérations financées par la BAD",
          style: GoogleFonts.inter(color: Colors.grey[600]),
        ),
      ],
    );
  }

  Widget _buildSearchBar() {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10)],
      ),
      child: TextField(
        controller: _searchController,
        onChanged: _filterProjects,
        decoration: InputDecoration(
          hintText: "Rechercher un projet (Code ou Nom)...",
          prefixIcon: const Icon(Icons.search),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(12),
            borderSide: BorderSide.none,
          ),
          contentPadding: const EdgeInsets.symmetric(vertical: 15),
        ),
      ),
    );
  }

  Widget _buildProjectList() {
    if (_filteredProjects.isEmpty) {
      return const Center(child: Text("Aucun projet ne correspond à votre recherche."));
    }

    return ListView.builder(
      itemCount: _filteredProjects.length,
      itemBuilder: (context, index) {
        final project = _filteredProjects[index];
        return Card(
          elevation: 0,
          margin: const EdgeInsets.only(bottom: 15),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
            side: const BorderSide(color: Colors.black12),
          ),
          child: ListTile(
            contentPadding: const EdgeInsets.all(15),
            leading: Container(
              width: 50,
              height: 50,
              decoration: BoxDecoration(
                color: primaryBlue.withOpacity(0.1),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Center(
                child: Text(
                  project.code,
                  style: TextStyle(color: primaryBlue, fontWeight: FontWeight.bold, fontSize: 10),
                  textAlign: TextAlign.center,
                ),
              ),
            ),
            title: Text(
              project.nom,
              style: GoogleFonts.inter(fontWeight: FontWeight.bold),
            ),
            subtitle: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const SizedBox(height: 5),
                Text("Catégorie: ${project.categorie}"),
                const SizedBox(height: 10),
                LinearProgressIndicator(
                  value: project.tauxExecution / 100,
                  backgroundColor: Colors.grey[200],
                  color: Colors.green,
                )
              ],
            ),
            trailing: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.end,
              children: [
                Text(
                  "${(project.budgetAlloue / 1000000).toStringAsFixed(1)} M FCFA",
                  style: const TextStyle(fontWeight: FontWeight.bold),
                ),
                const Text("Budget total", style: TextStyle(fontSize: 10, color: Colors.grey)),
              ],
            ),
          ),
        );
      },
    );
  }
}