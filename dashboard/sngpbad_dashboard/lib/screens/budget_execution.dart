import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class BudgetExecution extends StatelessWidget {
  const BudgetExecution({super.key});

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        _buildStatCards(),
        const SizedBox(height: 25),
        Expanded(child: _buildBudgetTable()),
      ],
    );
  }

  Widget _buildStatCards() {
    return Row(
      children: [
        _card("Total Alloué", "45.0 B CFA", Colors.blue),
        const SizedBox(width: 15),
        _card("Décaissement", "12.8 B CFA", Colors.green),
        const SizedBox(width: 15),
        _card("Reliquat", "32.2 B CFA", Colors.orange),
      ],
    );
  }

  Widget _card(String label, String value, Color color) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.black12)),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(label, style: GoogleFonts.inter(fontSize: 12, color: Colors.grey)),
            Text(value, style: GoogleFonts.montserrat(fontSize: 20, fontWeight: FontWeight.bold, color: color)),
          ],
        ),
      ),
    );
  }

  Widget _buildBudgetTable() {
    return Container(
      decoration: BoxDecoration(color: Colors.white, borderRadius: BorderRadius.circular(12), border: Border.all(color: Colors.black12)),
      child: ListView.separated(
        itemCount: 5,
        separatorBuilder: (context, index) => const Divider(height: 1),
        itemBuilder: (context, index) => ListTile(
          title: Text("Projet Infrastructure Zone ${index + 1}"),
          subtitle: Text("Convention N° BAD/CI/202${index}"),
          trailing: const Text("65%", style: TextStyle(fontWeight: FontWeight.bold)),
        ),
      ),
    );
  }
}