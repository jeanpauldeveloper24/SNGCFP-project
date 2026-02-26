import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:sngpbad_dashboard/models/project_model.dart';
import 'package:sngpbad_dashboard/services/project_service.dart';


class Statistic extends StatefulWidget {
  const Statistic({super.key});

  @override
  State<Statistic> createState() => _StatisticState();
}

class _StatisticState extends State<Statistic> {
  final Color primaryBlue = const Color(0xFF1B4F72);
  List<ProjectModel> _projects = [];
  bool _isLoading = true;

  // Variables pour les calculs KPI
  double totalBudgetAlloue = 0;
  double totalBudgetDepense = 0;
  double tauxMoyenExecution = 0;

  @override
  void initState() {
    super.initState();
    _loadData();
  }

  Future<void> _loadData() async {
    final projects = await ProjectService().fetchProjects();
    
    double alloc = 0;
    double depense = 0;
    double tauxAccumule = 0;

    for (var p in projects) {
      alloc += p.budgetAlloue;
      depense += p.budgetDepense;
      tauxAccumule += p.tauxExecution;
    }

    setState(() {
      _projects = projects;
      totalBudgetAlloue = alloc;
      totalBudgetDepense = depense;
      tauxMoyenExecution = projects.isNotEmpty ? tauxAccumule / projects.length : 0;
      _isLoading = false;
    });
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) return const Center(child: CircularProgressIndicator());

    return SingleChildScrollView(
      padding: const EdgeInsets.all(25),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text("Indicateurs de Performance (KPI)", 
            style: GoogleFonts.montserrat(fontSize: 22, fontWeight: FontWeight.bold, color: primaryBlue)),
          const SizedBox(height: 25),
          
          // Cartes KPI dynamiques
          Row(
            children: [
              _buildCard("PROJETS", _projects.length.toString(), Icons.folder, Colors.blue),
              _buildCard("BUDGET TOTAL", "${(totalBudgetAlloue / 1000000).toStringAsFixed(1)} M", Icons.payments, Colors.green),
              _buildCard("DÉCAISSEMENT", "${((totalBudgetDepense / totalBudgetAlloue) * 100).toStringAsFixed(1)}%", Icons.speed, Colors.orange),
              _buildCard("TAUX PHYSIQUE", "${tauxMoyenExecution.toStringAsFixed(1)}%", Icons.trending_up, Colors.purple),
            ],
          ),
          
          const SizedBox(height: 40),
          Text("Récapitulatif Financier par Projet", 
            style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold, color: primaryBlue)),
          const SizedBox(height: 15),
          
          _buildTable(),
        ],
      ),
    );
  }

  Widget _buildCard(String title, String value, IconData icon, Color color) {
    return Expanded(
      child: Container(
        margin: const EdgeInsets.all(8),
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 5)],
          border: Border.all(color: Colors.black12),
        ),
        child: Column(
          children: [
            Icon(icon, color: color, size: 30),
            const SizedBox(height: 10),
            Text(value, style: GoogleFonts.montserrat(fontSize: 18, fontWeight: FontWeight.bold)),
            Text(title, style: GoogleFonts.inter(fontSize: 10, color: Colors.grey, fontWeight: FontWeight.w600)),
          ],
        ),
      ),
    );
  }

  Widget _buildTable() {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.black12)),
      child: DataTable(
        headingRowColor: MaterialStateProperty.all(Colors.grey[50]),
        columns: const [
          DataColumn(label: Text("Code")),
          DataColumn(label: Text("Nom du Projet")),
          DataColumn(label: Text("Alloué (M)")),
          DataColumn(label: Text("Exécution")),
        ],
        rows: _projects.map((p) => DataRow(cells: [
          DataCell(Text(p.code, style: const TextStyle(fontWeight: FontWeight.bold))),
          DataCell(Text(p.nom)),
          DataCell(Text("${(p.budgetAlloue / 1000000).toStringAsFixed(1)}")),
          DataCell(_buildStatusChip(p.tauxExecution)),
        ])).toList(),
      ),
    );
  }

  Widget _buildStatusChip(double taux) {
    Color color = taux < 30 ? Colors.red : (taux < 70 ? Colors.orange : Colors.green);
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(color: color.withOpacity(0.1), borderRadius: BorderRadius.circular(20)),
      child: Text("${taux.toStringAsFixed(0)}%", style: TextStyle(color: color, fontWeight: FontWeight.bold, fontSize: 12)),
    );
  }
}